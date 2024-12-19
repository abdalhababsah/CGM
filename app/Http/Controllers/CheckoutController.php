<?php

namespace App\Http\Controllers;

use App\Http\Requests\ApplyDiscountCodeRequest;
use App\Http\Requests\CheckoutSubmitRequest;
use App\Http\Requests\GetDeliveryPriceRequest;
use App\Http\Requests\UpdateUserInfoRequest;
use App\Models\DeliveryLocationAndPrice;
use App\Models\DiscountCode;
use App\Models\Order;
use App\Services\CheckoutService;
use App\Services\CartService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckoutController extends Controller
{
    protected $checkoutService;
    protected $cartService;

    public function __construct(CheckoutService $checkoutService, CartService $cartService)
    {
        $this->checkoutService = $checkoutService;
        $this->cartService = $cartService;
    }

    /**
     * Display the checkout page.
     * If AJAX, return JSON data; else, return Blade view.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response|\Illuminate\View\View
     */
    public function index(Request $request)
    {
        // Fetch cart details
        $cartDetails = $this->cartService->getCartDetails();

        if (empty($cartDetails['items'])) {
            // If cart is empty, redirect back with an error message
            return redirect()->route('cart.index')->with('error', 'Your cart is empty. Add items before proceeding to checkout.');
        }

        // If cart has items, show checkout page
        return view('user.checkout');
    }

    // fetchCheckout: Fetch cart details and user information
    public function fetchCheckout(Request $request)
    {
        // Fetch required data
        $user = Auth::user();
        $cartDetails = $this->cartService->getCartDetails();
        $deliveryLocations = $this->fetchDeliveryLocations();
        $discountCode = session('applied_discount_code');

        return response()->json([
            'status' => 'success',
            'user' => [
                'first_name' => $user->first_name,
                'last_name' => $user->last_name,
                'email' => $user->email,
                'phone' => $user->phone,
            ],
            'cartItems' => $cartDetails['items'],
            'totalPrice' => $cartDetails['totalPrice'],
            'deliveryLocations' => $deliveryLocations,
            'discountCode' => $discountCode,
        ]);
    }
    /**
     * Fetch delivery locations based on locale.
     *
     * @return array
     */
    public function fetchDeliveryLocations()
    {
        $locale = app()->getLocale();

        $deliveryLocations = DeliveryLocationAndPrice::active()->get()->map(function ($delivery) use ($locale) {
            return [
                'id' => $delivery->id,
                'city' => $delivery->{'city_' . $locale},
                'country' => $delivery->{'country_' . $locale},
                'price' => $delivery->price,
            ];
        });

        return response()->json([
            'status' => 'success',
            'deliveryLocations' => $deliveryLocations,
        ]);
    }

    /**
     * Handle AJAX request to update user information.
     *
     * @param \App\Http\Requests\UpdateUserInfoRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function updateUserInfo(UpdateUserInfoRequest $request)
    {
        $user = Auth::user();
        $data = $request->only(['first_name', 'last_name', 'email', 'phone']);

        $user->update($data);

        return response()->json(['status' => 'success', 'message' => 'User information updated successfully.']);
    }

    /**
     * Handle AJAX request to get delivery price.
     *
     * @param \App\Http\Requests\GetDeliveryPriceRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getDeliveryPrice(GetDeliveryPriceRequest $request)
    {
        $deliveryLocation = DeliveryLocationAndPrice::find($request->delivery_location_id);

        if (!$deliveryLocation || !$deliveryLocation->is_active) {
            return response()->json(['status' => 'error', 'message' => 'Invalid delivery location.'], 400);
        }

        return response()->json([
            'status' => 'success',
            'price' => $deliveryLocation->price,
            'currency' => 'USD', // Adjust as needed
        ]);
    }

    /**
     * Handle AJAX request to apply a discount code.
     *
     * @param \App\Http\Requests\ApplyDiscountCodeRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    // app/Http/Controllers/CheckoutController.php

    public function applyDiscountCode(ApplyDiscountCodeRequest $request)
    {
        $discountCodeInput = strtoupper(trim($request->discount_code));
        $deliveryPrice = $request->delivery_price ?? 0;

        $cartDetails = $this->cartService->getCartDetails();
        $grandTotal = $cartDetails['totalPrice'] + $deliveryPrice;

        $result = $this->checkoutService->applyDiscountCode($discountCodeInput, $grandTotal);

        if ($result['status'] === 'success') {
            $discount = DiscountCode::where('code', $discountCodeInput)->first();

            // Calculate discount amount based on type
            if ($discount->type === 'percentage') {
                $discountAmount = ($grandTotal * $discount->value) / 100;
                $percentage = $discount->value;
            } else { // 'fixed'
                $discountAmount = $discount->value;
                $percentage = null;
            }

            // Store discount code in session
            session([
                'applied_discount_code' => [
                    'code' => $discountCodeInput,
                    'type' => $discount->type,
                    'amount' => $discountAmount,
                    'percentage' => $percentage, // Include percentage if applicable
                    'grand_total' => $result['grand_total'],
                ]
            ]);

            // Merge additional data into the response
            $result['code'] = $discountCodeInput;
            $result['type'] = $discount->type;

            if ($discount->type === 'percentage') {
                $result['percentage'] = $discount->value; // Add percentage to response
            }
        }

        return response()->json($result);
    }
    /**
     * Handle AJAX request to remove a discount code.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function removeDiscountCode()
    {
        session()->forget('applied_discount_code');

        return response()->json([
            'status' => 'success',
            'message' => 'Discount code removed successfully.',
        ]);
    }

    /**
     * Handle AJAX request to submit the checkout.
     *
     * @param \App\Http\Requests\CheckoutSubmitRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function submit(CheckoutSubmitRequest $request)
    {
        $validated = $request->validated();

        // Prepare data for the service
        $data = [
            'first_name' => $validated['first_name'],
            'last_name' => $validated['last_name'],
            'email' => $validated['email'],
            'phone' => $validated['phone'],
            'country' => $validated['country'],
            'city' => $validated['city'],
            'address' => $validated['address'],
            'note' => $validated['note'] ?? null,
            'delivery_location_id' => $validated['delivery_location_id'],
            'discount' => session('applied_discount_code'),
            'delivery_price' => $this->calculateDeliveryPrice($validated['delivery_location_id']),
        ];

        // Process checkout
        $order = $this->checkoutService->processCheckout($data);

        if ($order) {
            session()->forget('applied_discount_code');
            return response()->json(['status' => 'success', 'message' => 'Order placed successfully!', 'order_id' => $order->id]);
        } else {
            return response()->json(['status' => 'error', 'message' => 'There was an issue processing your order. Please try again.'], 500);
        }
    }

    /**
     * Calculate delivery price based on location ID.
     *
     * @param int $deliveryLocationId
     * @return float
     */
    protected function calculateDeliveryPrice($deliveryLocationId)
    {
        $deliveryLocation = DeliveryLocationAndPrice::find($deliveryLocationId);
        return $deliveryLocation ? $deliveryLocation->price : 0;
    }
    public function success($orderId)
    {
        $order = Order::findOrFail($orderId);

        return view('user.checkout-success', ['order' => $order]);
    }
}