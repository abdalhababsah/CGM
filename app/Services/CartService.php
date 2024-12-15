<?php

namespace App\Services;

use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\DB;

class CartService
{
    protected $cart;
    protected $cookieName = 'guest_cart';

    public function __construct()
    {
        if (Auth::check()) {
            // Retrieve or create a cart associated with the authenticated user
            $this->cart = Auth::user()->cart()->firstOrCreate([]);
        } else {
            $this->cart = null;
        }
    }

    /**
     * Add a product to the cart.
     *
     * @param int $productId
     * @param int $quantity
     * @return array
     */
    public function addToCart($productId, $quantity = 1)
    {
        $product = Product::find($productId);

        if (!$product || !$product->is_active) {
            return ['status' => 'error', 'message' => __('cart.product_not_found')];
        }

        if ($quantity < 1) {
            return ['status' => 'error', 'message' => __('cart.invalid_quantity')];
        }

        if (Auth::check()) {
            // User is authenticated, save to database
            $cartItem = $this->cart->cartItems()->where('product_id', $productId)->first();

            if ($cartItem) {
                $cartItem->quantity += $quantity;
                $cartItem->save();
            } else {
                $this->cart->cartItems()->create([
                    'product_id' => $productId,
                    'quantity' => $quantity,
                ]);
            }

            return ['status' => 'success', 'message' => __('cart.product_added')];
        } else {
            // Guest user, save to cookies
            $cart = $this->getGuestCart();

            if (isset($cart[$productId])) {
                $cart[$productId] += $quantity;
            } else {
                $cart[$productId] = $quantity;
            }

            $this->saveGuestCart($cart);

            return ['status' => 'success', 'message' => __('cart.product_added')];
        }
    }

    /**
     * Remove a product from the cart.
     *
     * @param int $productId
     * @return array
     */
    public function removeFromCart($productId)
    {
        if (Auth::check()) {
            $cartItem = $this->cart->cartItems()->where('product_id', $productId)->first();

            if ($cartItem) {
                $cartItem->delete();
                return ['status' => 'success', 'message' => __('cart.product_removed')];
            } else {
                return ['status' => 'error', 'message' => __('cart.product_not_in_cart')];
            }
        } else {
            $cart = $this->getGuestCart();

            if (isset($cart[$productId])) {
                unset($cart[$productId]);
                $this->saveGuestCart($cart);
                return ['status' => 'success', 'message' => __('cart.product_removed')];
            } else {
                return ['status' => 'error', 'message' => __('cart.product_not_in_cart')];
            }
        }
    }

    /**
     * Update the quantity of a product in the cart.
     *
     * @param int $productId
     * @param int $quantity
     * @return array
     */
    public function updateQuantity($productId, $quantity)
    {
        if ($quantity < 1) {
            return ['status' => 'error', 'message' => __('cart.invalid_quantity')];
        }
    
        $product = Product::find($productId);
    
        if (!$product || !$product->is_active) {
            return ['status' => 'error', 'message' => __('cart.product_not_found')];
        }
    
        if (Auth::check()) {
            // Update the cart for authenticated users
            $cartItem = $this->cart->cartItems()->where('product_id', $productId)->first();
    
            if ($cartItem) {
                $cartItem->quantity = $quantity;
                $cartItem->save();
            } else {
                return ['status' => 'error', 'message' => __('cart.product_not_in_cart')];
            }
        } else {
            // Update the cart for guest users
            $cart = $this->getGuestCart();
    
            if (isset($cart[$productId])) {
                $cart[$productId] = $quantity;
                $this->saveGuestCart($cart);
            } else {
                return ['status' => 'error', 'message' => __('cart.product_not_in_cart')];
            }
        }
    
        return ['status' => 'success', 'message' => __('cart.cart_updated')];
    }

    /**
     * Get all cart items.
     *
     * @return array
     */
    public function getCartItems()
    {
        if (Auth::check()) {
            $cartItems = $this->cart->cartItems()->with('product')->get();

            $items = $cartItems->map(function ($item) {
                return [
                    'product_id' => $item->product->id,
                    'name' => $this->getLocalizedName($item->product),
                    'price' => $item->product->price,
                    'quantity' => $item->quantity,
                    'total' => $item->quantity * $item->product->price,
                    'image_url' => $item->product->primaryImage ? asset('storage/' . $item->product->primaryImage->url) : 'https://via.placeholder.com/262x370',
                ];
            });

            return $items->toArray();
        } else {
            $cart = $this->getGuestCart();
            $items = [];

            foreach ($cart as $productId => $quantity) {
                $product = Product::find($productId);
                if ($product && $product->is_active) {
                    $items[] = [
                        'product_id' => $product->id,
                        'name' => $this->getLocalizedName($product),
                        'price' => $product->price,
                        'quantity' => $quantity,
                        'total' => $quantity * $product->price,
                        'image_url' => $product->primaryImage ? asset('storage/' . $product->primaryImage->url) : 'https://via.placeholder.com/262x370',
                    ];
                }
            }

            return $items;
        }
    }

    /**
     * Get total price of the cart.
     *
     * @return float
     */
    public function getTotalPrice()
    {
        $items = $this->getCartItems(); // Get the most up-to-date items
        $total = 0;
    
        foreach ($items as $item) {
            $productTotal = $item['price'] * $item['quantity'];
            $total += $productTotal;
        }
    
        return round($total, 2); // Ensure consistent rounding
    }

    /**
     * Get the guest cart from cookies.
     *
     * @return array
     */
    protected function getGuestCart()
    {
        $cart = Cookie::get($this->cookieName);

        return $cart ? json_decode($cart, true) : [];
    }

    /**
     * Save the guest cart to cookies.
     *
     * @param array $cart
     * @return void
     */
    protected function saveGuestCart($cart)
    {
        Cookie::queue($this->cookieName, json_encode($cart), 60 * 24 * 7); // 7 days
    }

    /**
     * Migrate guest cart to user cart upon login.
     *
     * @return void
     */
    public function migrateGuestCartToUser()
    {
        if (!Auth::check()) {
            return;
        }

        $guestCart = $this->getGuestCart();

        if (empty($guestCart)) {
            return;
        }

        DB::transaction(function () use ($guestCart) {
            foreach ($guestCart as $productId => $quantity) {
                $product = Product::find($productId);

                if ($product && $product->is_active) {
                    $cartItem = $this->cart->cartItems()->where('product_id', $productId)->first();

                    if ($cartItem) {
                        $cartItem->quantity += $quantity;
                        $cartItem->save();
                    } else {
                        $this->cart->cartItems()->create([
                            'product_id' => $productId,
                            'quantity' => $quantity,
                        ]);
                    }
                }
            }
        });

        // Clear the guest cart cookie
        Cookie::queue(Cookie::forget($this->cookieName));
    }

    /**
     * Helper function to get localized product name.
     *
     * @param \App\Models\Product $product
     * @return string
     */
    protected function getLocalizedName($product)
    {
        $locale = app()->getLocale();
        if ($locale === 'ar') {
            return $product->name_ar ?? $product->name_en;
        } elseif ($locale === 'he') {
            return $product->name_he ?? $product->name_en;
        } else {
            return $product->name_en;
        }
    }


    public function getCartDetails()
{
    $items = $this->getCartItems(); // Fetch cart items
    $totalPrice = $this->getTotalPrice(); // Calculate total price

    return [
        'items' => $items,
        'totalPrice' => $totalPrice,
    ];
}
}