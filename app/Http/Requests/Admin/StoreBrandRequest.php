<?php
namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class StoreBrandRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'name_en' => 'required|string|max:255',
            'name_ar' => 'nullable|string|max:255',
            'name_he' => 'nullable|string|max:255',
            'description_en' => 'nullable|string',
            'description_ar' => 'nullable|string',
            'description_he' => 'nullable|string',
            'logo_path' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'is_active' => 'required|boolean',
        ];
    }
}