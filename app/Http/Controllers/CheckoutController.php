<?php

namespace App\Http\Controllers;

use App\Http\Requests\ApplyDiscountCodeRequest;
use App\Http\Requests\CheckoutSubmitRequest;
use App\Http\Requests\UpdateUserInfoRequest;
use App\Models\Area;
use App\Models\DeliveryLocationAndPrice;
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

    public function __construct(
        CheckoutService $checkoutService,
        CartService $cartService,
        OrderService $orderService
    ) {
        $this->checkoutService = $checkoutService;
        $this->cartService = $cartService;
        $this->orderService = $orderService;
    }

    public function index()
    {
        $cartDetails = $this->cartService->getCartDetails();

        if (empty($cartDetails['items'])) {
            return redirect()->route('cart.index')
                ->with('error', __('Your cart is empty. Add items before proceeding to checkout.'));
        }

        return response()
            ->view('user.checkout')
            ->header('Cache-Control', 'no-cache, no-store, must-revalidate')
            ->header('Pragma', 'no-cache')
            ->header('Expires', '0');
    }

    public function fetchCheckout()
    {
        $user = Auth::user();
        $cartDetails = $this->cartService->getCartDetails();
        $discountCode = session('applied_discount_code');

        if ($discountCode) {
            $grandTotal = $cartDetails['totalPrice'];
            $result = $this->checkoutService->applyDiscountCode($discountCode['code'], $grandTotal);

            if ($result['status'] === 'success') {
                $discountCode['amount'] = $result['discount_amount'];
                $discountCode['discount'] = $result['discount'];
                $discountCode['grand_total'] = $result['grand_total'];
                $discountCode['message'] = $result['message'];
                session(['applied_discount_code' => $discountCode]);
            } else {
                session()->forget('applied_discount_code');
                $discountCode = null;
            }
        }
        
        $deliveryLocations = DeliveryLocationAndPrice::active()->get();

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
            'discountCode' => $discountCode,
            'deliveryLocations' => $deliveryLocations,
        ]);
    }

    public function updateUserInfo(UpdateUserInfoRequest $request)
    {
        $user = Auth::user();
        $data = $request->only(['first_name', 'last_name', 'email', 'phone']);
        $user->update($data);

        return response()->json([
            'status' => 'success',
            'message' => 'User information updated successfully.'
        ]);
    }

    public function applyDiscountCode(ApplyDiscountCodeRequest $request)
    {
        $discountCodeInput = strtoupper(trim($request->discount_code));
        $deliveryPrice = $request->delivery_price ?? 0;

        $cartDetails = $this->cartService->getCartDetails();
        $grandTotal = $cartDetails['totalPrice'];

        $result = $this->checkoutService->applyDiscountCode($discountCodeInput, $grandTotal);

        if ($result['status'] === 'success') {
            session([
                'applied_discount_code' => [
                    'code' => $discountCodeInput,
                    'type' => $result['type'],
                    'discount' => $result['discount'],
                    'amount' => $result['discount_amount'],
                    'message' => $result['message'],
                    'grand_total' => $result['grand_total'] + $deliveryPrice,
                ]
            ]);
        }

        return response()->json($result);
    }

    public function removeDiscountCode()
    {
        session()->forget('applied_discount_code');

        return response()->json([
            'status' => 'success',
            'message' => 'Discount code removed successfully.',
        ]);
    }

    public function submit(CheckoutSubmitRequest $request)
    {
        $validated = $request->validated();

        $data = [
            'first_name' => $validated['first_name'],
            'last_name' => $validated['last_name'],
            'email' => $validated['email'],
            'phone' => $validated['phone'],
            'phone2' => $validated['phone2'] ?? null,
            'delivery_location_id' => $validated['delivery_location_id'],
            'area' => $validated['area'] ?? null,
            'city' => $validated['city'],
            'address' => $validated['address'],
            'note' => $validated['note'] ?? null,
            'discount' => session('applied_discount_code'),
            'delivery_price' => $this->calculateDeliveryPrice($validated['delivery_location_id']),
        ];

        $order = $this->checkoutService->processCheckout($data);

        if ($order) {
            $this->orderService->postCheckout($order);
            session()->forget('applied_discount_code');
            return response()->json([
                'status' => 'success',
                'message' => 'Order placed successfully!',
            ]);
        }

        return response()->json([
            'status' => 'error',
            'message' => 'There was an issue processing your order. Please try again.'
        ], 500);
    }

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

        $areas = Area::where('delivery_location_id', $cityId)
            ->select(['id', 'area_' . app()->getLocale() . ' as name'])
            ->get();

        if ($areas->isEmpty()) {
            return response()->json([
                'status' => 'error',
                'message' => 'No areas found for this city.'
            ]);
        }

        return response()->json([
            'status' => 'success',
            'areas' => $areas,
        ]);
    }
}
