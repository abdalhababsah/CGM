<?php

namespace App\Http\Controllers;

use App\Models\HairPore;
use Illuminate\Http\Request;

class HairPoreController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $hairPores = HairPore::all();
        return view('hair_pores.index', compact('hairPores'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('hair_pores.create');
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

        HairPore::create($validated);
        return redirect()->route('hair_pores.index')->with('success', 'Hair Pore created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(HairPore $hairPore)
    {
        return view('hair_pores.show', compact('hairPore'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(HairPore $hairPore)
    {
        return view('hair_pores.edit', compact('hairPore'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, HairPore $hairPore)
    {
        $validated = $request->validate([
            'name_en' => 'required|string|max:255',
            'name_ar' => 'required|string|max:255',
            'name_he' => 'required|string|max:255',
        ]);

        $hairPore->update($validated);
        return redirect()->route('hair_pores.index')->with('success', 'Hair Pore updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(HairPore $hairPore)
    {
        $hairPore->delete();
        return redirect()->route('hair_pores.index')->with('success', 'Hair Pore deleted successfully.');
    }
}