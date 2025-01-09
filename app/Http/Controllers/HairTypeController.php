<?php

namespace App\Http\Controllers;

use App\Models\HairType;
use Illuminate\Http\Request;

class HairTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $hairTypes = HairType::all();
        return view('hair_types.index', compact('hairTypes'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('hair_types.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name_en' => 'required|string|max:255',
            'name_ar' => 'required|string|max:255',
            'name_he' => 'required|string|max:255',
        ]);

        HairType::create($validated);
        return redirect()->route('hair_types.index')->with('success', 'Hair Type created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(HairType $hairType)
    {
        return view('hair_types.show', compact('hairType'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(HairType $hairType)
    {
        return view('hair_types.edit', compact('hairType'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, HairType $hairType)
    {
        $validated = $request->validate([
            'name_en' => 'required|string|max:255',
            'name_ar' => 'required|string|max:255',
            'name_he' => 'required|string|max:255',
        ]);

        $hairType->update($validated);
        return redirect()->route('hair_types.index')->with('success', 'Hair Type updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(HairType $hairType)
    {
        $hairType->delete();
        return redirect()->route('hair_types.index')->with('success', 'Hair Type deleted successfully.');
    }
}