<?php

namespace App\Http\Controllers;

use App\Http\Requests\ApplyDiscountCodeRequest;
use App\Http\Requests\CheckoutSubmitRequest;
use App\Http\Requests\UpdateUserInfoRequest;
use App\Models\Area;
use App\Models\DeliveryLocationAndPrice;
use App\Models\DiscountCode;
use App\Models\Order;
use App\Services\CheckoutService;
use App\Services\CartService;
use App\Services\OrderService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckoutController extends Controller
{
    protected $checkoutService;
    protected $cartService;
    protected $orderService;

    public function __construct(CheckoutService $checkoutService, CartService $cartService, OrderService $orderService)
    {
        $this->checkoutService = $checkoutService;
        $this->cartService = $cartService;
        $this->orderService = $orderService;

    }

    public function index(Request $request)
    {
        // Fetch cart details
        $cartDetails = $this->cartService->getCartDetails();

        if (empty($cartDetails['items'])) {
            // If cart is empty, redirect back with an error message
            return redirect()->route('cart.index')
                ->with('error', 'Your cart is empty. Add items before proceeding to checkout.');
        }
        session()->forget('applied_discount_code');
        // Return the view but add headers to prevent caching
        $view = view('user.checkout'); // This is your Blade view

        return response($view)
            ->header('Cache-Control', 'no-cache, no-store, must-revalidate') // HTTP 1.1
            ->header('Pragma', 'no-cache') // HTTP 1.0
            ->header('Expires', '0');      // Proxies
    }

    // fetchCheckout: Fetch cart details and user information
    public function fetchCheckout(Request $request)
    {
        // Fetch required data
        $user = Auth::user();
        $cartDetails = $this->cartService->getCartDetails();
        // $deliveryLocations = $this->fetchDeliveryLocations();
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
            // 'deliveryLocations' => $deliveryLocations,
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
        $deliveryLocations = DeliveryLocationAndPrice::active()->get();

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
        $grandTotal = $cartDetails['totalPrice'];

        $result = $this->checkoutService->applyDiscountCode($discountCodeInput, $grandTotal);

        if ($result['status'] === 'success') {
            // Store discount code in session
            session([
                'applied_discount_code' => [
                    'code' => $discountCodeInput,
                    'type' => $result['type'],
                    'amount' => $result['discount_amount'],
                    'grand_total' => $result['grand_total'] + $deliveryPrice,
                ]
            ]);

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
        $validated = $request->all();

        // Prepare data for the service
        $data = [
            'first_name' => $validated['first_name'],
            'last_name' => $validated['last_name'],
            'email' => $validated['email'],
            'phone' => $validated['phone'],
            'phone2' => $validated['phone2'],

            // 'country' => $validated['country'],
            'delivery_location_id' => $validated['delivery_location_id'],//this city from delivery location
            'area' => $validated['area'] ?? null,
            'city' => $validated['city'],
            'address' => $validated['address'],
            'note' => $validated['note'] ?? null,
            'discount' => session('applied_discount_code'),
            'delivery_price' => $this->calculateDeliveryPrice($validated['delivery_location_id']),
        ];

        // Process checkout
        $order = $this->checkoutService->processCheckout($data);

        if ($order) {
            $this->orderService->postCheckout($order);

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
    public function success()
    {

        return view('user.checkout-success');
    }

    public function fetchAreas(Request $request)
    {
        $cityId = $request->city_id;

        // Fetch all areas linked to this city/delivery_location
        $areas = Area::where('delivery_location_id', $cityId)->get();

        if ($areas->isEmpty()) {
            return response()->json([
                'status' => 'error',
                'message' => 'No areas found for this city.'
            ]);
        }

        $mappedAreas = $areas->map(function ($area) {

            return [
                'id' => $area->id,
                'name' => $area->area,
            ];
        });

        return response()->json([
            'status' => 'success',
            'areas' => $mappedAreas,
        ]);
    }
}
