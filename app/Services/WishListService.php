<?php

namespace App\Services;

use App\Models\Product;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\DB;

class WishListService
{
    protected $wishList;
    protected $cookieName = 'guest_wishlist';

    public function __construct()
    {
        if (Auth::check()) {
            // Retrieve or create a wishlist for the authenticated user
            $this->wishList = Auth::user()->wishLists()->firstOrCreate([]);
        } else {
            $this->wishList = [];
        }
    }


    public function toggleWishList($productId)
    {
        $product = Product::find($productId);
        if (!$product || !$product->is_active) {
            return ['status' => 'error', 'message' => __('wishlist.product_not_found')];
        }

        if (Auth::check()) {
            // Authenticated user: Toggle in database
            $item = $this->wishList->wishListItems()->where('product_id', $productId)->first();
            if ($item) {
                // Product exists in wishlist; remove it
                $item->delete();
                return ['status' => 'removed', 'message' => __('wishlist.product_removed')];
            } else {
                // Product not in wishlist; add it
                $this->wishList->wishListItems()->create([
                    'product_id' => $productId,
                ]);
                return ['status' => 'added', 'message' => __('wishlist.product_added')];
            }
        } else {
            // Guest user: Toggle in cookie
            $wishlist = $this->getGuestWishList();
            $key = array_search($productId, $wishlist);
            if ($key !== false) {
                // Product exists in wishlist; remove it
                unset($wishlist[$key]);
                $wishlist = array_values($wishlist); // Reindex array
                $this->saveGuestWishList($wishlist);
                return ['status' => 'removed', 'message' => __('wishlist.product_removed')];
            } else {
                // Product not in wishlist; add it
                $wishlist[] = $productId;
                $this->saveGuestWishList($wishlist);
                return ['status' => 'added', 'message' => __('wishlist.product_added')];
            }
        }
    }
    /**
     * Add a product to the wishlist.
     *
     * @param int $productId
     * @return array
     */
    public function addToWishList($productId)
    {
        $product = Product::find($productId);
        if (!$product || !$product->is_active) {
            return ['status' => 'error', 'message' => __('wishlist.product_not_found')];
        }

        if (Auth::check()) {
            // Add to authenticated user's wishlist in the database
            $item = $this->wishList->wishListItems()->where('product_id', $productId)->first();
            if (!$item) {
                $this->wishList->wishListItems()->create([
                    'product_id' => $productId,
                ]);
            }
            return ['status' => 'success', 'message' => __('wishlist.product_added')];
        } else {
            // Guest user, add to cookie
            $wishlist = $this->getGuestWishList();
            if (!in_array($productId, $wishlist)) {
                $wishlist[] = $productId;
            }
            $this->saveGuestWishList($wishlist);
            return ['status' => 'success', 'message' => __('wishlist.product_added')];
        }
    }

    /**
     * Remove a product from the wishlist.
     *
     * @param int $productId
     * @return array
     */
    public function removeFromWishList($productId)
    {
        if (Auth::check()) {
            $item = $this->wishList->wishListItems()->where('product_id', $productId)->first();
            if ($item) {
                $item->delete();
                return ['status' => 'success', 'message' => __('wishlist.product_removed')];
            } else {
                return ['status' => 'error', 'message' => __('wishlist.product_not_in_wishlist')];
            }
        } else {
            $wishlist = $this->getGuestWishList();
            $key = array_search($productId, $wishlist);
            if ($key !== false) {
                unset($wishlist[$key]);
                $wishlist = array_values($wishlist); // reindex
                $this->saveGuestWishList($wishlist);
                return ['status' => 'success', 'message' => __('wishlist.product_removed')];
            } else {
                return ['status' => 'error', 'message' => __('wishlist.product_not_in_wishlist')];
            }
        }
    }

    /**
     * Get all wishlist items.
     *
     * @return array
     */
    public function getWishListItems()
    {
        if (Auth::check()) {
            $wishListItems = $this->wishList->wishListItems()->with('product')->get();
            $items = $wishListItems->map(function ($item) {
                return [
                    'product_id' => $item->product->id,
                    'sku' => $item->product->sku,
                    'name' => $this->getLocalizedName($item->product),
                    'price' => $item->product->price,
                    'in_stock' => $item->product->quantity > 0,
                    'image_url' => $item->product->primaryImage 
                        ? asset('storage/' . $item->product->primaryImage->image_url) 
                        : 'https://via.placeholder.com/110',
                ];
            });
            return $items->toArray();
        } else {
            $wishlist = $this->getGuestWishList();
            $items = [];
            foreach ($wishlist as $productId) {
                $product = Product::find($productId);
                if ($product && $product->is_active) {
                    $items[] = [
                        'product_id' => $product->id,
                        'name' => $this->getLocalizedName($product),
                        'price' => $product->price,
                        'in_stock' => $product->quantity > 0,
                        'image_url' => $product->primaryImage 
                            ? asset('storage/' . $product->primaryImage->image_url) 
                            : 'https://via.placeholder.com/110',
                    ];
                }
            }
            return $items;
        }
    }

    /**
     * Get the guest wishlist from cookies.
     *
     * @return array
     */
    protected function getGuestWishList()
    {
        $wishlist = Cookie::get($this->cookieName);
        return $wishlist ? json_decode($wishlist, true) : [];
    }

    /**
     * Save the guest wishlist to cookies.
     *
     * @param array $wishlist
     * @return void
     */
    protected function saveGuestWishList($wishlist)
    {
        Cookie::queue($this->cookieName, json_encode($wishlist), 60 * 24 * 7); // 7 days
    }

    /**
     * Migrate guest wishlist to user wishlist upon login.
     *
     * @return void
     */
    public function migrateGuestWishListToUser()
    {
        if (!Auth::check()) {
            return;
        }
        $guestWishList = $this->getGuestWishList();
        if (empty($guestWishList)) {
            return;
        }

        DB::transaction(function () use ($guestWishList) {
            foreach ($guestWishList as $productId) {
                $product = Product::find($productId);
                if ($product && $product->is_active) {
                    $item = $this->wishList->wishListItems()->where('product_id', $productId)->first();
                    if (!$item) {
                        $this->wishList->wishListItems()->create([
                            'product_id' => $productId,
                        ]);
                    }
                }
            }
        });

        // Clear the guest wishlist cookie
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
    public function getWishListIds()
    {
        if (Auth::check()) {
            return $this->wishList->wishListItems()->pluck('product_id')->toArray();
        } else {
            $wishlist = $this->getGuestWishList();
            return $wishlist;
        }
    }
}