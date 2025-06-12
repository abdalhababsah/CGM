<?php

namespace App\Http\Controllers;

use App\Models\ProductColor;
use App\Services\CheckoutService;
use Exception;
use Illuminate\Http\Request;
use App\Services\CartService;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Log;

class CartController extends Controller
{
    protected $cartService;
    protected $checkoutService;

    public function __construct(
        CartService $cartService,
        CheckoutService $checkoutService
        )
    {
        $this->cartService = $cartService;
        $this->checkoutService = $checkoutService;
    }

    /**
     * Display the cart page.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        return view('user.cart');
    }
    public function fetchCart()
    {
        $cartDetails = $this->cartService->getCartDetails();

        $discountData = session('applied_discount_code');
        $discountCode = null;
        $discountAmount = 0;

        if ($discountData) {
            $discountCode = $discountData['code'] ?? null;

            // Recalculate discount amount based on current total
            $type = $discountData['type'] ?? null;
            $discountValue = $discountData['discount'] ?? 0;
            $total = $cartDetails['totalPrice'];

            if ($type === 'percentage') {
                $discountAmount = round($total * ($discountValue / 100), 2);
            } elseif ($type === 'fixed') {
                $discountAmount = min($discountValue, $total);
            } else {
                $discountAmount = 0;
            }
        }

        Log::info('Cart Details:', ['cartDetails' => $cartDetails, 'discountCode' => $discountCode, 'discountAmount' => $discountAmount]);
        Log::info('Discount Data:', ['discountData' => $discountData, 'discountAmount' => $discountAmount]);

        return response()->json([
            'cartItems' => $cartDetails['items'],
            'totalPrice' => $cartDetails['totalPrice'],
            'discount' => $discountData,
            'discountAmount' => $discountAmount,
        ]);
    }

    /**
     * Add a product to the cart.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function add(Request $request)
    {
        try {

        $request->validate([
            'product_id' => 'required|integer|exists:products,id',
            'quantity' => 'integer|min:1',
            'color_id' => [Rule::exists('product_colors', 'id')->where('product_id', $request->product_id),],
        ]);

        $productId = $request->input('product_id');
        $quantity = $request->input('quantity', 1);
        $colorId = $request->input('color_id', null);

        $result = $this->cartService->addToCart($productId, $quantity, $colorId);

        return response()->json($result);
        } catch (Exception $th) {
            Log::error($th->getMessage());
        }
    }

    /**
     * Remove a product from the cart.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function remove(Request $request)
    {
        $request->validate([
            'product_id' => 'required|integer|exists:products,id',
        ]);

        $productId = $request->input('product_id');

        $result = $this->cartService->removeFromCart($productId);

        if ($result['status'] === 'success') {
            $cartDetails = $this->cartService->getCartDetails();
            $result['cartItems'] = $cartDetails['items'];
            $result['totalPrice'] = $cartDetails['totalPrice'];
        }

        return response()->json($result);
    }

    /**
     * Update the quantity of a product in the cart.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */

    public function updateQuantity(Request $request)
    {
        $request->validate([
            'product_id' => 'required|integer|exists:products,id',
            'color_id' => 'nullable|integer|exists:product_colors,id',
            'quantity' => 'required|integer|min:1',
        ]);
        $productId = $request->input('product_id');
        $colortId = $request->input('color_id');
        $quantity = $request->input('quantity');

        $result = $this->cartService->updateQuantity($productId, $quantity, $colortId);

        if ($result['status'] === 'success') {
            // Fetch the entire cart details (items and total price)
            $cartDetails = $this->cartService->getCartDetails();
            $result['cartItems'] = $cartDetails['items'];
            $result['totalPrice'] = $cartDetails['totalPrice'];
        }
        return response()->json($result);
    }
    /**
    * Get the current cart count.
    *
    * @return \Illuminate\Http\JsonResponse
    */
    public function getCartCount()
    {
        $cartDetails = $this->cartService->getCartDetails();
        $cartCount = count($cartDetails['items']);

        return response()->json(['cart_count' => $cartCount]);
    }
}
