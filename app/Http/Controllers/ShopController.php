<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;
use App\Models\Brand;

class ShopController extends Controller
{
    /**
     * Display the shop page.
     */
    public function index()
    {
        return view("user.shop");
    }

    /**
     * Handle AJAX requests to fetch products, categories, and brands.
     */
    public function fetchProducts(Request $request)
    {
        // Initialize the product query with relationships
        $query = Product::with(['brand', 'category'])
                        ->where('is_active', 1)
                        ->whereHas('brand', function ($q) {
                            $q->where('is_active', 1);
                        })
                        ->whereHas('category', function ($q) {
                            $q->where('is_active', 1);
                        });

        // Apply search filter
        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function($q) use ($search){
                $q->where('name_en', 'like', "%{$search}%")
                  ->orWhere('name_ar', 'like', "%{$search}%")
                  ->orWhere('name_he', 'like', "%{$search}%");
            });
        }

        // Filter by category
        if ($request->filled('category')) {
            $query->where('category_id', $request->input('category'));
        }

        // Filter by brand
        if ($request->filled('brand')) {
            $query->where('brand_id', $request->input('brand'));
        }

        // Filter by price range
        if ($request->filled('price_min') && $request->filled('price_max')) {
            $query->whereBetween('price', [$request->input('price_min'), $request->input('price_max')]);
        }

        // Sorting
        if ($request->filled('sort')) {
            switch ($request->input('sort')) {
                case 'price_asc':
                    $query->orderBy('price', 'asc');
                    break;
                case 'price_desc':
                    $query->orderBy('price', 'desc');
                    break;
                // Add more sorting options if needed
                default:
                    $query->orderBy('created_at', 'desc');
                    break;
            }
        }

        // Pagination (9 products per page)
        $products = $query->paginate(9);

        // Fetch all active categories and brands
        $categories = Category::where('is_active', 1)->get();
        $brands = Brand::where('is_active', 1)->get();

        // Return JSON response
        return response()->json([
            'categories' => $categories,
            'brands' => $brands,
            'products' => $products
        ]);
    }
}