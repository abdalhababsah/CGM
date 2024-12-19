<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProfileUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return true; // Adjust authorization logic if necessary
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'email' => [
                'required',
                'string',
                'lowercase',
                'email',
                'max:255',
                Rule::unique(User::class)->ignore($this->user()->id),
            ],
        ];
    }

    /**
     * Get custom messages for validator errors.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'name.required' => __('profile.name_required'),
            'name.string' => __('profile.name_must_be_string'),
            'name.max' => __('profile.name_max_length'),

            'email.required' => __('profile.email_required'),
            'email.string' => __('profile.email_must_be_string'),
            'email.lowercase' => __('profile.email_must_be_lowercase'),
            'email.email' => __('profile.email_invalid'),
            'email.max' => __('profile.email_max_length'),
            'email.unique' => __('profile.email_unique'),
        ];
    }
}