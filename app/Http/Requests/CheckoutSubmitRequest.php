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
        return true;
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
            'area' => 'required|integer|exists:areas,id',
            'note' => 'nullable|string|max:1000',
        ];
    }
}
