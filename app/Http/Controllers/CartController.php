<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\CartService;

class CartController extends Controller
{
    protected $cartService;

    public function __construct(CartService $cartService)
    {
        $this->cartService = $cartService;
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
        return response()->json([
            'cartItems' => $cartDetails['items'],
            'totalPrice' => $cartDetails['totalPrice'],
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
        $request->validate([
            'product_id' => 'required|integer|exists:products,id',
            'quantity' => 'integer|min:1',
        ]);

        $productId = $request->input('product_id');
        $quantity = $request->input('quantity', 1);

        $result = $this->cartService->addToCart($productId, $quantity);

        return response()->json($result);
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
             'quantity' => 'required|integer|min:1',
         ]);
     
         $productId = $request->input('product_id');
         $quantity = $request->input('quantity');
     
         $result = $this->cartService->updateQuantity($productId, $quantity);
     
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