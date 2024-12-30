<?php
namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class StoreCategoryRequest extends FormRequest
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
            'logo_path' => 'nullable|image|mimes:jpeg,png,jpg,gif',
            'is_active' => 'required|boolean',
        ];
    }

    public function messages(): array
    {
        return [
            'name_en.required' => 'The English name is required.',
            'name_en.string' => 'The English name must be a string.',
            'name_en.max' => 'The English name may not be greater than 255 characters.',
            'name_ar.string' => 'The Arabic name must be a string.',
            'name_ar.max' => 'The Arabic name may not be greater than 255 characters.',
            'name_he.string' => 'The Hebrew name must be a string.',
            'name_he.max' => 'The Hebrew name may not be greater than 255 characters.',
            'description_en.string' => 'The English description must be a string.',
            'description_ar.string' => 'The Arabic description must be a string.',
            'description_he.string' => 'The Hebrew description must be a string.',
            'logo_path.image' => 'The logo must be an image file.',
            'logo_path.mimes' => 'The logo must be a file of type: jpeg, png, jpg, gif.',
            'logo_path.max' => 'The logo may not be greater than 2 MB.',
            'is_active.required' => 'The status is required.',
            'is_active.boolean' => 'The status must be true or false.',
        ];
    }
}