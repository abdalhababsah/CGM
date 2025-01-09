<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\HairThickness;
use Illuminate\Http\Request;

class HairThicknessController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $hairThicknesses = HairThickness::paginate(10);
        return view('admin.hair_thickness.index', compact('hairThicknesses'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name_en' => 'required|string|max:255',
            'name_ar' => 'required|string|max:255',
            'name_he' => 'required|string|max:255',

        ]);

        HairThickness::create([
            'name_en' => $request->name_en,
            'name_ar' => $request->name_ar,
            'name_he' => $request->name_he,

        ]);

        return redirect()->route('admin.hair-thickness.index')->with('success', 'Hair Thickness created successfully.');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, HairThickness $hairThickness)
    {
        $request->validate([
            'name_en' => 'required|string|max:255',
            'name_ar' => 'required|string|max:255',
            'name_he' => 'required|string|max:255',

        ]);

        $hairThickness->update([
            'name_en' => $request->name_en,
            'name_ar' => $request->name_ar,
            'name_he' => $request->name_he,

        ]);

        return redirect()->route('admin.hair-thickness.index')->with('success', 'Hair Thickness updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(HairThickness $hairThickness)
    {
        $hairThickness->delete();
        return redirect()->route('admin.hair-thickness.index')->with('success', 'Hair Thickness deleted successfully.');
    }
}