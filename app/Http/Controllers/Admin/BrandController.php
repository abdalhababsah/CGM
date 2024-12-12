<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreBrandRequest;
use App\Http\Requests\Admin\UpdateBrandRequest;
use App\Models\Brand;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BrandController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $brands = Brand::all(); // Fetch all brands
        return view('admin.brands.index', compact('brands'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.brands.create'); // Render create view
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreBrandRequest $request)
    {
        $validated = $request->validated();
    
        // Save the uploaded logo with timestamp and UUID
        if ($request->hasFile('logo_path')) {
            $file = $request->file('logo_path');
            $fileName = time() . '_' . (string) \Str::uuid() . '.' . $file->getClientOriginalExtension();
            $validated['logo_url'] = $file->storeAs('brands', $fileName, 'public');
        }
    
        // Create the brand
        Brand::create($validated);
    
        return redirect()->route('admin.brands.index')->with('success', 'Brand created successfully.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Brand $brand)
    {
        return view('admin.brands.create', compact('brand')); // Reuse create view for editing
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateBrandRequest $request, Brand $brand)
    {
        $validated = $request->validated();
    
        // Update the logo if a new one is uploaded
        if ($request->hasFile('logo_path')) {
            // Delete the old logo if it exists
            if ($brand->logo_url && Storage::disk('public')->exists($brand->logo_url)) {
                Storage::disk('public')->delete($brand->logo_url);
            }
    
            $file = $request->file('logo_path');
            $fileName = time() . '_' . (string) \Str::uuid() . '.' . $file->getClientOriginalExtension();
            $validated['logo_url'] = $file->storeAs('brands', $fileName, 'public');
        }
    
        // Update the brand
        $brand->update($validated);
    
        return redirect()->route('admin.brands.index')->with('success', 'Brand updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Brand $brand)
    {
        // Delete the logo if exists
        if ($brand->logo_url && Storage::disk('public')->exists($brand->logo_url)) {
            Storage::disk('public')->delete($brand->logo_url);
        }

        // Delete the brand
        $brand->delete();

        return redirect()->route('admin.brands.index')->with('success', 'Brand deleted successfully.');
    }
}