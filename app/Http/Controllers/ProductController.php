<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Services\WishListService;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    protected $wishListService;

    public function __construct(WishListService $wishListService)
    {
        $this->wishListService = $wishListService;
    }

    public function show($id, $slug)
    {
        try {
            $product = Product::with(['images', 'category', 'brand'])->findOrFail($id);
            
            // Get all wishlist product IDs
            $wishlistIds = $this->wishListService->getWishListIds();
            
            // Check if current product is in wishlist
            $isInWishlist = in_array($product->id, $wishlistIds);
            
            return view("user.view-product", compact("product", "isInWishlist"));
        } catch (ModelNotFoundException $e) {
            return redirect()->route('shop.index')->with('error', __('shop.product_not_found'));
        }
    }
}