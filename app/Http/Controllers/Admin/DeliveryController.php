<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\DeliveryLocationAndPrice;
use Illuminate\Http\Request;

class DeliveryController extends Controller
{
    /**
     * Display a listing of the delivery locations.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        // Fetch all delivery locations with pagination
        $deliveries = DeliveryLocationAndPrice::orderBy('id', 'desc')->paginate(10);

        return view('admin.deliveries.index', compact('deliveries'));
    }

    /**
     * Show the form for creating a new delivery location or editing an existing one.
     *
     * @param  \App\Models\DeliveryLocationAndPrice|null  $delivery
     * @return \Illuminate\View\View
     */
    public function create(DeliveryLocationAndPrice $delivery = null)
    {
        // If a delivery is provided, we're editing; otherwise, creating
        $isEdit = $delivery ? true : false;

        return view('admin.deliveries.create', compact('delivery', 'isEdit'));
    }

    /**
     * Store a newly created delivery location in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        // Validate the incoming request data, including multilingual fields
        $validatedData = $request->validate([
            'city_en' => 'required|string|max:255',
            'city_ar' => 'nullable|string|max:255',
            'city_he' => 'nullable|string|max:255',
            'price' => 'required|numeric|min:0',
            'is_active' => 'required|boolean',
        ]);

        // Create a new delivery location with the validated data
        DeliveryLocationAndPrice::create($validatedData);

        // Redirect back to the deliveries index with a success message
        return redirect()->route('admin.deliveries.index')->with('success', 'Delivery location created successfully.');
    }

    /**
     * Show the form for editing the specified delivery location.
     *
     * @param  \App\Models\DeliveryLocationAndPrice  $delivery
     * @return \Illuminate\View\View
     */
    public function edit(DeliveryLocationAndPrice $delivery)
    {
        // Delegate to the create method with the delivery instance for editing
        return $this->create($delivery);
    }

    /**
     * Update the specified delivery location in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\DeliveryLocationAndPrice  $delivery
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, DeliveryLocationAndPrice $delivery)
    {
        // Validate the incoming request data, including multilingual fields
        $validatedData = $request->validate([
            'city_en' => 'required|string|max:255',
            'city_ar' => 'nullable|string|max:255',
            'city_he' => 'nullable|string|max:255',
            'price' => 'required|numeric|min:0',
            'is_active' => 'required|boolean',
        ]);

        // Update the delivery location with the validated data
        $delivery->update($validatedData);

        // Redirect back to the deliveries index with a success message
        return redirect()->route('admin.deliveries.index')->with('success', 'Delivery location updated successfully.');
    }

    /**
     * Remove the specified delivery location from storage.
     *
     * @param  \App\Models\DeliveryLocationAndPrice  $delivery
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(DeliveryLocationAndPrice $delivery)
    {
        // Delete the specified delivery location
        $delivery->delete();

        // Redirect back to the deliveries index with a success message
        return redirect()->route('admin.deliveries.index')->with('success', 'Delivery location deleted successfully.');
    }
}