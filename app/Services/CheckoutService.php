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
    protected $orderService;
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

        $discountAmount = $this->orderService->calculateDiscount($discount, $grandTotal);


        return [
            'status' => 'success',
            'message' => __('Discount code applied successfully.'),
            'type' => $discount->type,
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
        Log::info('Checkout Data:', $data);
        $cartDetails = $this->cartService->getCartDetails();
        $totalPrice = $cartDetails['totalPrice'];
        $deliveryLocation = $data['delivery_location_id'];
        $deliveryPrice = $data['delivery_price'] ?? 0;
        $grandTotal = $totalPrice + $deliveryPrice;
        $area_id = $data['area'];
        // Apply discount if any
        $discountData = $data['discount'] ?? null;
        // if ($discountData) {
        //     $grandTotal -= $discountData['amount'];
        //     // Ensure grand total is not negative
        //     $grandTotal = max($grandTotal, 0);
        // }
        DB::beginTransaction();

        try {
            $user = Auth::user();
            if ($user) {
                $user->update([
                    'first_name' => $data['first_name'] ?? $user->first_name,
                    'last_name' => $data['last_name'] ?? $user->last_name,
                    'phone' => $data['phone'] ?? $user->phone,
                    'email' => $data['email'] ?? $user->email,
                ]);

            }
            // Fetch discount code if applicable
            $discountCode = null;
            if ($discountData) {
                // $this->applyDiscountCode($discountData['code'], $totalPrice);
                $discountCode = DiscountCode::where('code', $discountData['code'])->first();
                if (!$discountCode) {
                    Log::warning('Discount Code Not Found:', ['code' => $discountData['code']]);
                    throw new \Exception('Discount code not found.');
                }
                // Increment discount usage
                $discountCode?->incrementUsage();
            }

            // Create Order
            $order = Order::create([
                'user_id' => Auth::id(),
                'delivery_location_id' => $deliveryLocation,
                'discount_code_id' => $discountCode ? $discountCode->id : null,
                'area_id' => $area_id,
                'total_amount' => $grandTotal,
                'discount' => $discountData['amount']?? 0,
                'finalPrice' => $grandTotal - ($discountData['amount']?? 0),
                'payment_method' => 'Cash on Delivery',
                'status' => 'Pending',
                'phone2'=> $data['phone2'] ?? $user->phone,
                'preferred_language' => Auth::user()->preferred_language ?? 'en',
                'note' => $data['note'] ?? null,
            ]);
                Log::info('Order information updated:', $order->toArray());

            // Create Order Location
            OrderLocation::create([
                'order_id' => $order->id,
                'city' => $data['city'],
                'address' => $data['address'],
                // 'longitude' => $data['longitude'] ?? null,
            ]);

            // Create Order Items
            $orderItems = [];
            foreach ($cartDetails['items'] as $item) {
                $orderItems[] =[
                    'order_id' => $order->id,
                    'product_id' => $item['product_id'],
                    'quantity' => $item['quantity'],
                    'unit_price' => $item['price'],
                    'total_price' => $item['total'],
                    'hex' => $item['color'] ?? null,
                ];
            }
            OrderItem::insert($orderItems);
        Log::info('item order', $orderItems);
            // Update product quantities
            foreach ($cartDetails['items'] as $item) {
                $product = Product::find($item['product_id']);
                if ($product) {
                    $product->decrement('quantity', $item['quantity']);
                }
            }

            // Clear the cart
            $this->cartService->clearCart();
            DB::commit();

            // Dispatch the event after the transaction
            event(new OrderPlaced($order));
            return $order;
        } catch (\Exception $e) {
            DB::rollback();
            Log::error('Checkout Error: ' . $e);
            return false;
        }
    }
}
