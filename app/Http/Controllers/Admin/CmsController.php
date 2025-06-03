<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Comming_soon;
use App\Models\HeaderSlider;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
class CmsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $sliders = cache()->remember('header_sliders', 60 * 60, function () {
            $sliders = HeaderSlider::all();
            if ($sliders->isEmpty()) {
            HeaderSlider::create([
                'title_ar' => 'خصم 30٪ على جميع المنتجات',
                'title_en' => '30% OFF ON ALL PRODUCTS ENTER CODE: BESHOP2020',
                'title_he' => '30% הנחה על כל המוצרים קוד: BESHOP2020',
            ]);
            $sliders = HeaderSlider::all();
            }
            return $sliders;
        });

        $commingSoons = Comming_soon::orderBy("created_at", "desc")->paginate(10);
        return view("admin.commingSoon.index", compact("commingSoons", 'sliders'));
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
            "image" => "nullable|image",
        ]);

        // Handle the image upload if present
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $fileName = time() . '_' . (string) Str::uuid() . '.' . $file->getClientOriginalExtension();
            $data['image'] = $file->storeAs('commingsoon', $fileName, 'public'); // Save the file and store the path
        }

        // Create the new Comming Soon section
        $commingSoon = Comming_soon::create($data);
        return redirect()->route('admin.cms-management.index')->with('success', 'Section Created Successfully');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Comming_soon $cms_management)
    {
        // Validate the input data
        $data = $request->validate([
            "name_ar" => "required|string|max:255",
            "name_en" => "required|string|max:255",
            "name_he" => "required|string|max:255",
            "image" => "nullable|image", // Ensure the uploaded file is a valid image
        ]);

        // Handle the image upload if present
        if ($request->hasFile('image')) {
            if ($cms_management->image && Storage::disk('public')->exists($cms_management->image)) {
                Storage::disk('public')->delete($cms_management->image);
            }

            // Store the new image
            $file = $request->file('image');
            $fileName = time() . '_' . (string) Str::uuid() . '.' . $file->getClientOriginalExtension();
            $data['image'] = $file->storeAs('commingsoon', $fileName, 'public');
        }

        // Update the record
        $cms_management->update($data);

        // Redirect with a success message
        return redirect()->route('admin.cms-management.index')->with('success', 'Section Updated Successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $commingSoon = Comming_soon::find($id);
        try {
            $commingSoon->delete();
            return redirect()->route('admin.cms-management.index')->with('success', 'Section Deleted successfully.');

        } catch (ModelNotFoundException $e) {
            return redirect()->route('admin.cms-management.index')->with('error', 'Error Occurred While Deleting the Section');
        }


    }
    /**
     * Update the Header Slider.
     */
    public function updateHeader(Request $request, HeaderSlider $slider)
    {
        try {
            // Validate the request data
            $data = $request->validate([
                'title_ar' => 'required|string|max:255',
                'title_en' => 'required|string|max:255',
                'title_he' => 'required|string|max:255',
            ]);

            // Update the Header Slider
            $slider->update($data);

            return redirect()
                ->route('admin.cms-management.index')
                ->with('success', 'Header Slider updated successfully.');

        } catch (\Exception $e) {
            return redirect()
                ->route('admin.cms-management.index')
                ->with('error', 'Error updating Header Slider: ' . $e->getMessage());
        }
    }
}
