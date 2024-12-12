<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Http\Requests\Admin\StoreCategoryRequest;
use App\Http\Requests\Admin\UpdateCategoryRequest;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::all();
        return view('admin.categories.index', compact('categories'));
    }

    public function create()
    {
        return view('admin.categories.create');
    }

    public function store(StoreCategoryRequest $request)
    {
        $validated = $request->validated();

        // Save the uploaded logo with timestamp and UUID as the file name
        if ($request->hasFile('logo_path')) {
            $file = $request->file('logo_path');
            $fileName = time() . '_' . Str::uuid() . '.' . $file->getClientOriginalExtension();
            $validated['logo_url'] = $file->storeAs('categories', $fileName, 'public');
        }

        // Create the category
        Category::create($validated);

        return redirect()->route('admin.categories.index')->with('success', 'Category created successfully.');
    }

    public function edit(Category $category)
    {
        return view('admin.categories.create', compact('category'));
    }

    public function update(UpdateCategoryRequest $request, Category $category)
    {
        $validated = $request->validated();

        // Update the logo if a new one is uploaded
        if ($request->hasFile('logo_path')) {
            // Delete the old logo if it exists
            if ($category->logo_url && Storage::disk('public')->exists($category->logo_url)) {
                Storage::disk('public')->delete($category->logo_url);
            }

            // Save the new logo with timestamp and UUID as the file name
            $file = $request->file('logo_path');
            $fileName = time() . '_' . Str::uuid() . '.' . $file->getClientOriginalExtension();
            $validated['logo_url'] = $file->storeAs('categories', $fileName, 'public');
        }

        // Update the category
        $category->update($validated);

        return redirect()->route('admin.categories.index')->with('success', 'Category updated successfully.');
    }

    public function destroy(Category $category)
    {
        // Delete the logo if it exists
        if ($category->logo_url && Storage::disk('public')->exists($category->logo_url)) {
            Storage::disk('public')->delete($category->logo_url);
        }

        // Delete the category
        $category->delete();

        return redirect()->route('admin.categories.index')->with('success', 'Category deleted successfully.');
    }
}