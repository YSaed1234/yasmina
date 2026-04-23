<?php

namespace Modules\Vendor\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProductRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'category_id' => 'required|exists:categories,id',
            'ar.name' => 'required|string|max:255',
            'en.name' => 'required|string|max:255',
            'ar.description' => 'nullable|string',
            'en.description' => 'nullable|string',
            'price' => 'required|numeric',
            'discount_price' => 'nullable|numeric|lte:price',
            'flash_sale_price' => 'nullable|numeric|lte:price',
            'flash_sale_expires_at' => 'nullable|date',
            'is_gift' => 'nullable|boolean',
            'gift_threshold' => 'nullable|numeric',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ];
    }
}
