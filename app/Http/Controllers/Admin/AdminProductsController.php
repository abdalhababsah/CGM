<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use App\Models\Brand;
use App\Models\ProductImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class AdminProductsController extends Controller
{
    /**
     * Display a listing of the products.
     */
    public function index(Request $request)
    {
        // Retrieve categories and brands for filter options
        $categories = Category::all();
        $brands = Brand::all();
    
        // Query for filtering
        $query = Product::with(['category', 'brand']);
    
        // Search by name (in all supported languages)
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name_en', 'like', '%' . $search . '%')
                  ->orWhere('name_ar', 'like', '%' . $search . '%')
                  ->orWhere('name_he', 'like', '%' . $search . '%');
            });
        }
    
        // Filter by category
        if ($request->filled('category_id')) {
            $query->where('category_id', $request->category_id);
        }
    
        // Filter by brand
        if ($request->filled('brand_id')) {
            $query->where('brand_id', $request->brand_id);
        }
    
        // Filter by status (active/inactive)
        if ($request->filled('status')) {
            $query->where('is_active', $request->status === 'active');
        }
    
        // Paginated results
        $products = $query->paginate(10)->appends($request->except('page'));
    
        return view('admin.products.index', compact('products', 'categories', 'brands'));
    }

    /**
     * Show the form for creating a new product.
     */
    public function create()
    {
        $categories = Category::all();
        $brands = Brand::all();
        return view('admin.products.create', compact('categories', 'brands'));
    }

    /**
     * Store a newly created product in storage.
     */
    public function store(Request $request)
    {
        // Validate the request
        $validated = $request->validate([
            'name_en' => 'required|string|max:255',
            'name_ar' => 'required|string|max:255',
            'name_he' => 'required|string|max:255',
            'description_en' => 'nullable|string',
            'description_ar' => 'nullable|string',
            'description_he' => 'nullable|string',
            'category_id' => 'required|exists:categories,id',
            'brand_id' => 'nullable|exists:brands,id',
            'is_active' => 'required|boolean',
            'price' => 'required|numeric|min:0',
            'quantity' => 'required|integer|min:0',
            'is_primary' => 'nullable|image', // Max 2MB
            'images.*' => 'nullable|image',   // Max 2MB per image
        ]);
    
        // Create the product
        $product = new Product($validated);
        $product->sku = $request->sku ?? strtoupper(Str::random(10)); // Generate SKU if not provided
        $product->save();
    
        // Handle primary image upload
        if ($request->hasFile('is_primary')) {
            $this->handlePrimaryImageUpload($request->file('is_primary'), $product);
        }
    
        // Handle additional images upload
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $this->handleAdditionalImageUpload($image, $product);
            }
        }
    
        // Check if the request expects JSON
        if ($request->expectsJson()) {
            return response()->json([
                'message' => 'Product created successfully.',
                'product' => $product, // Return the created product
            ], 201);
        }
    
        // Default redirect for standard form submission
        return redirect()->route('admin.products.index')->with('success', 'Product created successfully.');
    }

    /**
     * Show the form for editing the specified product.
     */
    public function edit(Product $product)
    {
        $categories = Category::all();
        $brands = Brand::all();
        $product->load('images');
        return view('admin.products.edit', compact('product', 'categories', 'brands'));
    }

    /**
     * Fetch additional images for the specified product (AJAX).
     */
    public function fetchImages(Product $product)
    {
        $images = $product->images()->where('is_primary', false)->get();

        return response()->json(['images' => $images], 200);
    }

    /**
     * Update the specified product's general information.
     */
    public function updateGeneralInfo(Request $request, Product $product)
    {
        $validated = $request->validate([
            'name_en' => 'required|string|max:255',
            'name_ar' => 'required|string|max:255',
            'name_he' => 'required|string|max:255',
            'description_en' => 'nullable|string',
            'description_ar' => 'nullable|string',
            'description_he' => 'nullable|string',
        ]);

        $product->update($validated);

        return response()->json(['message' => 'General information updated successfully.'], 200);
    }

    /**
     * Update the specified product's options.
     */
    public function updateOptions(Request $request, Product $product)
    {
        $validated = $request->validate([
            'category_id' => 'required|exists:categories,id',
            'brand_id' => 'nullable|exists:brands,id',
            'is_active' => 'required|boolean',
            'price' => 'required|numeric|min:0',
            'quantity' => 'required|integer|min:0',
        ]);

        $product->update($validated);

        return response()->json(['message' => 'Options updated successfully.'], 200);
    }

    /**
     * Upload new additional images for the specified product.
     */
    public function uploadAdditionalImages(Request $request, Product $product)
    {
        // dd($request);
        // Validate additional images
        $validated = $request->validate([
            'images.*' => 'required|image', // Max 2MB per image
        ]);

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $this->handleAdditionalImageUpload($image, $product);
            }
        }

        return response()->json(['message' => 'Additional images uploaded successfully.'], 200);
    }

    /**
     * Update the primary image of the specified product.
     */
    public function updatePrimaryImage(Request $request, Product $product)
    {
        // Validate the uploaded file
        $validated = $request->validate([
            'is_primary' => 'required|file|image', // Validate file type and size
        ]);
    
        if ($request->hasFile('is_primary')) {
            // Handle primary image upload
            $this->handlePrimaryImageUpload($request->file('is_primary'), $product);
    
            // Fetch the new primary image
            $primaryImage = $product->images()->where('is_primary', true)->first();
    
            return response()->json([
                'message' => 'Primary image updated successfully.',
                'primary_image_url' => asset('storage/' . $primaryImage->image_url),
            ], 200);
        }
    
        return response()->json([
            'message' => 'No image file provided.',
        ], 422);
    }
    /**
     * Remove the specified product from storage.
     */
    public function destroy(Product $product)
    {
        // Delete all images associated with the product
        foreach ($product->images as $image) {
            if (Storage::disk('public')->exists($image->image_url)) {
                Storage::disk('public')->delete($image->image_url);
            }
            $image->delete();
        }

        $product->delete();

        return redirect()->route('admin.products.index')->with('success', 'Product deleted successfully.');
    }

    /**
     * Delete an additional image.
     */
    public function deleteImage(ProductImage $image)
    {
        // Ensure the image belongs to a product
        if (!$image->product) {
            return response()->json(['message' => 'Image does not belong to any product.'], 404);
        }

        // Prevent deleting the primary image through this method
        if ($image->is_primary) {
            return response()->json(['message' => 'Cannot delete the primary image using this method.'], 403);
        }

        // Delete the image file
        Storage::disk('public')->delete($image->image_url);

        // Delete the image record
        $image->delete();

        return response()->json(['message' => 'Image deleted successfully.'], 200);
    }

    /**
     * Handle the upload of an additional image.
     *
     * @param  \Illuminate\Http\UploadedFile  $image
     * @param  \App\Models\Product  $product
     */
    protected function handleAdditionalImageUpload($image, Product $product)
    {
        $filename = time() . '_' . Str::random(10) . '.' . $image->getClientOriginalExtension();
        $path = $image->storeAs('products', $filename, 'public');
        $product->images()->create(['image_url' => $path, 'is_primary' => false]);
    }

    /**
     * Handle the upload of the primary image.
     *
     * @param  \Illuminate\Http\UploadedFile  $image
     * @param  \App\Models\Product  $product
     */
    protected function handlePrimaryImageUpload($image, Product $product)
    {
        // Delete existing primary image if any
        $primaryImage = $product->images()->where('is_primary', true)->first();
        if ($primaryImage) {
            Storage::disk('public')->delete($primaryImage->image_url);
            $primaryImage->delete();
        }

        // Save new primary image
        $filename = time() . '_primary_' . Str::random(10) . '.' . $image->getClientOriginalExtension();
        $path = $image->storeAs('products', $filename, 'public');
        $product->images()->create(['image_url' => $path, 'is_primary' => true]);
    }
}