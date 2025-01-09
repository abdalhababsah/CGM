<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\HairType;
use Illuminate\Http\Request;

class HairTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $hairTypes = HairType::paginate(10);
        return view('admin.hair_type.index', compact('hairTypes'));
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

        HairType::create($request->only(['name_en', 'name_ar', 'name_he']));

        return redirect()->route('admin.hair-type.index')->with('success', 'Hair Type created successfully.');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, HairType $hairType)
    {
        $request->validate([
            'name_en' => 'required|string|max:255',
            'name_ar' => 'required|string|max:255',
            'name_he' => 'required|string|max:255',
        ]);

        $hairType->update($request->only(['name_en', 'name_ar', 'name_he']));

        return redirect()->route('admin.hair-type.index')->with('success', 'Hair Type updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(HairType $hairType)
    {
        $hairType->delete();
        return redirect()->route('admin.hair-type.index')->with('success', 'Hair Type deleted successfully.');
    }
}