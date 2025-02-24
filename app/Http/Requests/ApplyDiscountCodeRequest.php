<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ApplyDiscountCodeRequest extends FormRequest
{


    public function rules(): array
    {
        return [
            'discount_code' => ['required', 'string', 'max:50'],
            // 'delivery_price' => ['required', 'numeric', 'min:0'],
        ];
    }

    /**
     * Customize the error messages.
     */
    public function messages()
    {
        return [
            'discount_code.required' => __('checkout.discount_code_required'),
            'discount_code.string' => __('checkout.discount_code_must_be_string'),
            'discount_code.max' => __('checkout.discount_code_max_length'),
            // 'delivery_price.required' => __('checkout.delivery_price_required'),
            // 'delivery_price.numeric' => __('checkout.delivery_price_must_be_numeric'),
            // 'delivery_price.min' => __('checkout.delivery_price_minimum'),
        ];
    }
}
