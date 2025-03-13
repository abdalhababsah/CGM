<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CheckoutSubmitRequest extends FormRequest
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

    public function rules()
    {
        return [
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required|numeric|digits:10',
            'phone2' => 'required|numeric|digits:10',
            'city' => 'required|string|max:255',
            'address' => 'required|string|max:255',
            'delivery_location_id' => 'required|integer|exists:delivery_location_and_prices,id',
            'area' => 'required|integer',
            'note' => 'nullable|string|max:1000',
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
            'first_name.required' => __('checkout.first_name_required'),
            'first_name.string' => __('checkout.first_name_must_be_string'),
            'first_name.max' => __('checkout.first_name_max_length'),

            'last_name.required' => __('checkout.last_name_required'),
            'last_name.string' => __('checkout.last_name_must_be_string'),
            'last_name.max' => __('checkout.last_name_max_length'),

            'email.required' => __('checkout.email_required'),
            'email.email' => __('checkout.email_invalid'),
            'email.max' => __('checkout.email_max_length'),

            'phone.required' => __('checkout.phone_required'),
            'phone.string' => __('checkout.phone_must_be_string'),
            'phone.digits' => __('checkout.phone_max_length'),

            'city.required' => __('checkout.city_required'),
            'city.string' => __('checkout.city_must_be_string'),
            'city.max' => __('checkout.city_max_length'),

            'address.required' => __('checkout.address_required'),
            'address.string' => __('checkout.address_must_be_string'),
            'address.max' => __('checkout.address_max_length'),

            'delivery_location_id.required' => __('checkout.delivery_location_required'),
            'delivery_location_id.integer' => __('checkout.delivery_location_must_be_integer'),
            'delivery_location_id.exists' => __('checkout.delivery_location_invalid'),

            'note.string' => __('checkout.note_must_be_string'),
            'note.max' => __('checkout.note_max_length'),

            'discount_code.string' => __('checkout.discount_code_must_be_string'),
            'discount_code.max' => __('checkout.discount_code_max_length'),
        ];
    }
}
