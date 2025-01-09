<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\HairPore;
use Illuminate\Http\Request;

class HairPoreController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $hairPores = HairPore::paginate(10);
        return view('admin.hair_pore.index', compact('hairPores'));
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

        HairPore::create($request->only(['name_en', 'name_ar', 'name_he']));

        return redirect()->route('admin.hair-pore.index')->with('success', 'Hair Pore created successfully.');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, HairPore $hairPore)
    {
        $request->validate([
            'name_en' => 'required|string|max:255',
            'name_ar' => 'required|string|max:255',
            'name_he' => 'required|string|max:255',
        ]);

        $hairPore->update($request->only(['name_en', 'name_ar', 'name_he']));

        return redirect()->route('admin.hair-pore.index')->with('success', 'Hair Pore updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(HairPore $hairPore)
    {
        $hairPore->delete();
        return redirect()->route('admin.hair-pore.index')->with('success', 'Hair Pore deleted successfully.');
    }
}