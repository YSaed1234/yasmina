<?php

namespace Modules\Admin\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreProductRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'category_id' => 'required|exists:categories,id',
            'currency_id' => 'required|exists:currencies,id',
            'ar.name' => 'required|string|max:255',
            'en.name' => 'required|string|max:255',
            'ar.description' => 'nullable|string',
            'en.description' => 'nullable|string',
            'price' => 'required|numeric',
            'discount_price' => 'nullable|numeric|lte:price',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'rank' => 'nullable|integer',
            'vendor_id' => 'nullable|exists:vendors,id',
        ];
    }
}
