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
            'price' => 'required|numeric|min:0.00',
            'discount_price' => 'nullable|numeric|min:0.00|lte:price',
            'flash_sale_price' => 'nullable|numeric|min:0.00|lte:price',
            'flash_sale_expires_at' => 'nullable|date',
            'is_gift' => 'nullable|boolean',
            'gift_threshold' => 'nullable|numeric|min:0',
            'currency_id' => 'required|exists:currencies,id',
            'stock' => 'required|integer|min:0',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'custom_badge' => 'nullable|string|max:50',
            'variants' => 'nullable|array',
            'variants.*.id' => 'nullable|exists:product_variants,id',
            'variants.*.color' => 'nullable|string|max:50',
            'variants.*.size' => 'nullable|string|max:50',
            'variants.*.price' => 'nullable|numeric|min:0',
            'variants.*.stock' => 'nullable|integer|min:0',
            'variants.*.sku' => 'nullable|string|max:100',
            'variants.*.image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ];
    }

    public function messages(): array
    {
        return [
            'price.min' => __('السعر يجب أن يكون أكبر من 0'),
            'discount_price.min' => __('سعر الخصم يجب أن يكون أكبر من 0'),
            'flash_sale_price.min' => __('سعر الفلاش سيل يجب أن يكون أكبر من 0'),
            'discount_price.lte' => __('سعر الخصم يجب أن يكون أقل من أو يساوي السعر الأساسي'),
            'flash_sale_price.lte' => __('سعر الفلاش سيل يجب أن يكون أقل من أو يساوي السعر الأساسي'),
        ];
    }
}
