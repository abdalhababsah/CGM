<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\DiscountCode;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class DiscountCodeController extends Controller
{
    /**
     * Display a listing of the discount codes.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        // Fetch all discount codes with pagination
        $discountCodes = DiscountCode::orderBy('id', 'desc')->paginate(10);

        // Return the index view with discount codes
        return view('admin.discount.index', compact('discountCodes'));
    }

    /**
     * Show the form for creating a new discount code.
     * @return \Illuminate\View\View
     */
    public function create()
    {
        // Return the create view
        return view('admin.discount.create');
    }

    /**
     * Store a newly created discount code in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        // Validate the incoming request data
        $validatedData = $request->validate([
            'code' => 'required|string|max:50|unique:discount_codes,code',
            'type' => ['required', Rule::in(['fixed', 'percentage'])],
            'amount' => 'required|numeric|min:0',
            'usage_limit' => 'nullable|integer|min:1',
            'expiry_date' => 'nullable|date|after_or_equal:today',
            'is_active' => 'required|boolean',
        ]);

        // Create the discount code
        DiscountCode::create($validatedData);

        // Redirect back with success message
        return redirect()->route('admin.discount.index')->with('success', 'Discount code created successfully.');
    }

    /**
     * Show the form for editing the specified discount code.
     *
     * @param  \App\Models\DiscountCode  $discount
     * @return \Illuminate\View\View
     */
    public function edit(DiscountCode $discount)
    {
        // Return the edit view with the discount code
        return view('admin.discount.edit', compact('discount'));
    }

    /**
     * Update the specified discount code in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\DiscountCode  $discount
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, DiscountCode $discount)
    {
        // Validate the incoming request data
        $validatedData = $request->validate([
            'code' => [
                'required',
                'string',
                'max:50',
                Rule::unique('discount_codes', 'code')->ignore($discount->id),
            ],
            'type' => ['required', Rule::in(['fixed', 'percentage'])],
            'amount' => 'required|numeric|min:0',
            'usage_limit' => 'nullable|integer|min:1',
            'expiry_date' => 'nullable|date|after_or_equal:today',
            'is_active' => 'required|boolean',
        ]);

        // Update the discount code
        $discount->update($validatedData);

        // Redirect back with success message
        return redirect()->route('admin.discount.index')->with('success', 'Discount code updated successfully.');
    }

    /**
     * Remove the specified discount code from storage.
     *
     * @param  \App\Models\DiscountCode  $discount
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(DiscountCode $discount)
    {
        // Delete the discount code
        $discount->delete();

        // Redirect back with success message
        return redirect()->route('admin.discount.index')->with('success', 'Discount code deleted successfully.');
    }
}