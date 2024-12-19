<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateUserInfoRequest extends FormRequest
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
            'first_name' => ['required', 'string', 'max:255'],
            'last_name'  => ['required', 'string', 'max:255'],
            'email'      => ['required', 'email', 'max:255'],
            'phone'      => ['required', 'string', 'max:20'],
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
            'first_name.required' => __('user_info.first_name_required'),
            'first_name.string' => __('user_info.first_name_must_be_string'),
            'first_name.max' => __('user_info.first_name_max_length'),

            'last_name.required' => __('user_info.last_name_required'),
            'last_name.string' => __('user_info.last_name_must_be_string'),
            'last_name.max' => __('user_info.last_name_max_length'),

            'email.required' => __('user_info.email_required'),
            'email.email' => __('user_info.email_invalid'),
            'email.max' => __('user_info.email_max_length'),

            'phone.required' => __('user_info.phone_required'),
            'phone.string' => __('user_info.phone_must_be_string'),
            'phone.max' => __('user_info.phone_max_length'),
        ];
    }
}