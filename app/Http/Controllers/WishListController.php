<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\WishListService;

class WishListController extends Controller
{
    protected $wishListService;

    public function __construct(WishListService $wishListService)
    {
        $this->wishListService = $wishListService;
    }

    public function index()
    {
        $items = $this->wishListService->getWishListItems();
        if (request()->ajax()) {
            return response()->json(['items' => $items]);
        }
        return view("user.wishlist", compact('items'));
    }

    public function add(Request $request)
    {
        $request->validate([
            'product_id' => 'required|integer|exists:products,id',
        ]);
        $productId = $request->input('product_id');
        $result = $this->wishListService->addToWishList($productId);
        return response()->json($result);
    }

    public function remove(Request $request)
    {
        $request->validate([
            'product_id' => 'required|integer|exists:products,id',
        ]);
        $productId = $request->input('product_id');
        $result = $this->wishListService->removeFromWishList($productId);
        if ($result['status'] === 'success') {
            $items = $this->wishListService->getWishListItems();
            $result['items'] = $items;
        }
        return response()->json($result);
    }
    public function toggle(Request $request)
    {
        $request->validate([
            'product_id' => 'required|integer|exists:products,id',
        ]);

        $productId = $request->input('product_id');
        $result = $this->wishListService->toggleWishList($productId);

        if ($result['status'] === 'added' || $result['status'] === 'removed') {
            $items = $this->wishListService->getWishListItems();
            $result['items'] = $items;
        }

        return response()->json($result);
    }
}