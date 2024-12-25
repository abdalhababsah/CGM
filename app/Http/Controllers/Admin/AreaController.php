<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Area;
use App\Models\DeliveryLocationAndPrice;
use Illuminate\Http\Request;

class AreaController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');
        $deliveryLocationId = $request->input('delivery_location_id');
    
        $areas = Area::query()
            ->when($search, function ($query, $search) {
                $query->where('area_en', 'like', "%$search%")
                      ->orWhere('area_ar', 'like', "%$search%")
                      ->orWhere('area_he', 'like', "%$search%");
            })
            ->when($deliveryLocationId, function ($query, $deliveryLocationId) {
                $query->where('delivery_location_id', $deliveryLocationId);
            })
            ->paginate(10)
            ->appends([
                'search' => $search,
                'delivery_location_id' => $deliveryLocationId,
            ]);
    
        $deliveryLocations = DeliveryLocationAndPrice::active()->get();
    
        return view('admin.areas.index', compact('areas', 'deliveryLocations'));
    }

    public function create()
    {
        $deliveryLocations = DeliveryLocationAndPrice::active()->get();
        return view('admin.areas.create', compact('deliveryLocations'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'delivery_location_id' => 'required|exists:delivery_location_and_prices,id',
            'area_en' => 'required|string|max:255',
            'area_ar' => 'required|string|max:255',
            'area_he' => 'required|string|max:255',
            'company_area_id' => 'nullable|string|max:255',
        ]);

        Area::create($request->all());
        return redirect()->route('admin.areas.index')->with('success', 'Area created successfully.');
    }

    public function edit(Area $area)
    {
        $deliveryLocations = DeliveryLocationAndPrice::active()->get();
        return view('admin.areas.edit', compact('area', 'deliveryLocations'));
    }

    public function update(Request $request, Area $area)
    {
        $request->validate([
            'delivery_location_id' => 'required|exists:delivery_location_and_prices,id',
            'area_en' => 'required|string|max:255',
            'area_ar' => 'required|string|max:255',
            'area_he' => 'required|string|max:255',
            'company_area_id' => 'nullable|string|max:255',
        ]);

        $area->update($request->all());
        return redirect()->route('admin.areas.index')->with('success', 'Area updated successfully.');
    }

    public function destroy(Area $area)
    {
        $area->delete();
        return redirect()->route('admin.areas.index')->with('success', 'Area deleted successfully.');
    }
}