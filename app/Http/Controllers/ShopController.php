<?php

namespace App\Http\Controllers;

use App\Models\HairPore;
use App\Models\HairThickness;
use App\Models\HairType;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;
use App\Models\Brand;
use App\Services\WishListService;
use Illuminate\Validation\ValidationException;

class ShopController extends Controller
{
    /**
     * Display the shop page.
     */

    protected $wishListService;

    public function __construct(WishListService $wishListService)
    {
        $this->wishListService = $wishListService;
    }

    public function index()
    {
        return view("user.shop");
    }

    /**
     * Handle AJAX requests to fetch products, categories, brands, and new filters.
     */
    public function fetchProducts(Request $request)
    {
        // **Backend Validation: Remove selection limits for multi-select filters**
        try {
            $validated = $request->validate([
                'categories' => 'array', // Allow multiple categories
                'brands' => 'array', // Allow multiple brands
                'hair_pores' => 'array', // Removed 'max:2'
                'hair_types' => 'array', // Removed 'max:2'
                'hair_thicknesses' => 'array', // Removed 'max:2'
                // Add other validations as needed
            ]);
        } catch (ValidationException $e) {
            return response()->json([
                'error' => __('shop.invalid_filter_selection'),
            ], 422);
        }

        // Initialize the product query with relationships
        $query = Product::with(['brand', 'category', 'primaryImage'])
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

        // Filter by multiple categories
        if ($request->filled('categories')) {
            $selectedCategories = $request->input('categories'); // expecting array of IDs
            if (is_array($selectedCategories) && count($selectedCategories) > 0) {
                $query->whereIn('category_id', $selectedCategories);
            }
        }

        // Filter by multiple brands
        if ($request->filled('brands')) {
            $selectedBrands = $request->input('brands'); // expecting array of IDs
            if (is_array($selectedBrands) && count($selectedBrands) > 0) {
                $query->whereIn('brand_id', $selectedBrands);
            }
        }

        // Filter by price range
        if ($request->filled('price_min') && $request->filled('price_max')) {
            $query->whereBetween('price', [$request->input('price_min'), $request->input('price_max')]);
        }

        // **New Filters: Hair Pores, Hair Types, Hair Thicknesses**

        // Filter by Hair Pores
        if ($request->filled('hair_pores')) {
            $hairPores = $request->input('hair_pores'); // expecting array of IDs
            if (is_array($hairPores) && count($hairPores) > 0) {
                $query->whereHas('hairPores', function ($q) use ($hairPores) {
                    $q->whereIn('hair_pores.id', $hairPores);
                });
            }
        }

        // Filter by Hair Types
        if ($request->filled('hair_types')) {
            $hairTypes = $request->input('hair_types'); // expecting array of IDs
            if (is_array($hairTypes) && count($hairTypes) > 0) {
                $query->whereHas('hairTypes', function ($q) use ($hairTypes) {
                    $q->whereIn('hair_types.id', $hairTypes);
                });
            }
        }

        // Filter by Hair Thicknesses
        if ($request->filled('hair_thicknesses')) {
            $hairThicknesses = $request->input('hair_thicknesses'); // expecting array of IDs
            if (is_array($hairThicknesses) && count($hairThicknesses) > 0) {
                $query->whereHas('hairThicknesses', function ($q) use ($hairThicknesses) {
                    $q->whereIn('hair_thicknesses.id', $hairThicknesses);
                });
            }
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

        // **Fetch Hair Pores, Hair Types, and Hair Thicknesses**
        $hair_pores = HairPore::all();
        $hair_types = HairType::all();
        $hair_thicknesses = HairThickness::all();

        // Retrieve current wishlist IDs
        $wishlistIds = $this->wishListService->getWishListIds();

        // Add 'is_in_wishlist' flag to each product
        $products->getCollection()->transform(function($product) use ($wishlistIds) {
            $product->is_in_wishlist = in_array($product->id, $wishlistIds);
            return $product;
        });

        // Return JSON response
        return response()->json([
            'categories' => $categories,
            'brands' => $brands,
            'products' => $products,
            'hair_pores' => $hair_pores,
            'hair_types' => $hair_types,
            'hair_thicknesses' => $hair_thicknesses
        ]);
    }
}