<?php

namespace App\Services;

use App\Models\DiscountCode;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\OrderLocation;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use App\Events\OrderPlaced;

class CheckoutService
{
    protected $cartService;

    public function __construct(CartService $cartService, OrderService $orderService)
    {
        $this->cartService = $cartService;
        $this->orderService = $orderService;
    }

    /**
     * Apply discount code logic.
     *
     * @param string $code
     * @param float $grandTotal
     * @return array
     */
    public function applyDiscountCode($code, $grandTotal)
    {
        $code = strtoupper(trim($code));
        $discount = DiscountCode::where('code', $code)->where('is_active', true)->first();

        if (!$discount) {
            return ['status' => 'error', 'message' => 'Invalid or inactive discount code.'];
        }

        // Check expiry date
        if ($discount->expiry_date && Carbon::now()->isAfter(Carbon::parse($discount->expiry_date))) {
            return ['status' => 'error', 'message' => 'This discount code has expired.'];
        }

        // Check usage limit
        if ($discount->usage_limit && $discount->times_used >= $discount->usage_limit) {
            return ['status' => 'error', 'message' => 'This discount code has reached its usage limit.'];
        }

        // Calculate discount amount based on type
        if ($discount->type === 'fixed') {
            $discountAmount = $discount->amount;
        } elseif ($discount->type === 'percentage') {
            $discountAmount = ($discount->amount / 100) * $grandTotal;
        } else {
            return ['status' => 'error', 'message' => 'Invalid discount type.'];
        }

        // Ensure discount does not exceed grand total
        $discountAmount = min($discountAmount, $grandTotal);
        $discountAmount = round($discountAmount, 2);

        // Increment discount usage
        $discount->incrementUsage();

        return [
            'status' => 'success',
            'message' => 'Discount code applied successfully.',
            'discount_amount' => $discountAmount,
            'grand_total' => round($grandTotal - $discountAmount, 2),
        ];
    }

    /**
     * Process the checkout submission.
     *
     * @param array $data
     * @return Order|bool
     */
    public function processCheckout(array $data)
    {
        // dd($data);
        // Log incoming data for debugging
        Log::info('Processing checkout with data:', $data);

        $cartDetails = $this->cartService->getCartDetails();
        $totalPrice = $cartDetails['totalPrice'];
        $deliveryLocation = $data['delivery_location_id'];
        $deliveryPrice = $data['delivery_price'] ?? 0;
        $grandTotal = $totalPrice + $deliveryPrice;
        $area_id =$data['area'];
        // Apply discount if any
        $discountData = $data['discount'] ?? null;
        if ($discountData) {
            $grandTotal -= $discountData['amount'];
            // Ensure grand total is not negative
            $grandTotal = max($grandTotal, 0);
        }
        DB::beginTransaction();

        try {
            // Fetch discount code if applicable
            $discountCode = null;
            if ($discountData) {
                $discountCode = DiscountCode::where('code', $discountData['code'])->first();
                if ($discountCode) {
                    Log::info('Discount Code Found:', ['code' => $discountCode->code, 'id' => $discountCode->id]);
                } else {
                    Log::warning('Discount Code Not Found:', ['code' => $discountData['code']]);
                    throw new \Exception('Discount code not found.');
                }
            }

            // Create Order
            $order = Order::create([
                'user_id' => Auth::id(),
                'delivery_location_id' => $deliveryLocation,
                'discount_code_id' => $discountCode ? $discountCode->id : null,
                'area_id' => $area_id,
                'total_amount' => $grandTotal,
                'payment_method' => 'Cash on Delivery',
                'status' => 'Pending',
                'preferred_language' => Auth::user()->preferred_language ?? 'en',
                'note' => $data['note'] ?? null,
            ]);

            // Create Order Location
            $orderLocation = OrderLocation::create([
                'order_id' => $order->id,
                'country'  => $data['country'],
                'city'     => $data['city'],
                'address'    => $data['address'],
                'longitude'=> $data['longitude'] ?? null,
            ]);
            // Create Order Items
            foreach ($cartDetails['items'] as $item) {
                OrderItem::create([
                    'order_id'    => $order->id,
                    'product_id'  => $item['product_id'],
                    'quantity'    => $item['quantity'],
                    'unit_price'  => $item['price'],
                    'total_price' => $item['total'],
                ]);
            }

            // Update product quantities
            foreach ($cartDetails['items'] as $item) {
                $product = Product::find($item['product_id']);
                if ($product) {
                    $product->decrement('quantity', $item['quantity']);
                }
            }

            // Clear the cart
            $this->cartService->clearCart();
            $this->orderService->postCheckout($order); 
            DB::commit();

            return $order;
        } catch (\Exception $e) {
            DB::rollback();
            Log::error('Checkout Error: ' . $e->getMessage());
            return false;
        }
    }
}