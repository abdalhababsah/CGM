<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Comming_soon;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
class CommingSoonController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $commingSoons = Comming_soon::orderBy("created_at","desc")->paginate(10);
        return view("admin.commingSoon.index", compact("commingSoons"));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
    
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validate the input data
        $data = $request->validate([
            "name_ar" => "required|string|max:255",
            "name_en" => "required|string|max:255",
            "name_he" => "required|string|max:255",
            "image"   => "nullable|image", 
        ]);
    
        // Handle the image upload if present
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $fileName = time() . '_' . (string) Str::uuid() . '.' . $file->getClientOriginalExtension();
            $data['image'] = $file->storeAs('commingsoon', $fileName, 'public'); // Save the file and store the path
        }
    
        // Create the new Comming Soon section
        $commingSoon = Comming_soon::create($data);
        return redirect()->route('admin.comming-soon.index')->with('success', 'Section Created Successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**CRUD
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Comming_soon $commingSoon)
    {
        // Validate the input data
        $data = $request->validate([
            "name_ar" => "required|string|max:255",
            "name_en" => "required|string|max:255",
            "name_he" => "required|string|max:255",
            "image"   => "nullable|image", // Ensure the uploaded file is a valid image
        ]);
    
        // Handle the image upload if present
        if ($request->hasFile('image')) {
            if ($commingSoon->image && Storage::disk('public')->exists($commingSoon->image)) {
                Storage::disk('public')->delete($commingSoon->image);
            }
    
            // Store the new image
            $file = $request->file('image');
            $fileName = time() . '_' . (string) Str::uuid() . '.' . $file->getClientOriginalExtension();
            $data['image'] = $file->storeAs('commingsoon', $fileName, 'public');
        }
    
        // Update the record
        $commingSoon->update($data);
    
        // Redirect with a success message
        return redirect()->route('admin.comming-soon.index')->with('success', 'Section Updated Successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $commingSoon = Comming_soon::find($id);
        try {
            $commingSoon->delete();
            return redirect()->route('admin.comming-soon.index')->with('success','Section Deleted successfully.');
    
        }catch (ModelNotFoundException $e) {
            return redirect()->route('admin.comming-soon.index')->with('error','Error Occurred While Deleting the Section') ;
        }
            

    }
}
