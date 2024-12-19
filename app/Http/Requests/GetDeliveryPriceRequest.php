<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class GetDeliveryPriceRequest extends FormRequest
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
            'delivery_location_id' => ['required', 'integer', 'exists:delivery_location_and_prices,id'],
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
            'delivery_location_id.required' => __('checkout.delivery_location_required'),
            'delivery_location_id.integer' => __('checkout.delivery_location_must_be_integer'),
            'delivery_location_id.exists' => __('checkout.delivery_location_invalid'),
        ];
    }
}