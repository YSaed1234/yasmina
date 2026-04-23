<?php

namespace Modules\Admin\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateVendorRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
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
    public function rules(): array
    {
        $vendorId = $this->route('vendor')->id;

        return [
            'name' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:vendors,slug,' . $vendorId,
            'logo' => 'nullable|image|max:5120',
            'about_image1' => 'nullable|image|max:5120',
            'about_image2' => 'nullable|image|max:5120',
            'email' => 'required|email|unique:vendors,email,' . $vendorId,
            'phone' => 'nullable|string',
            'phone_secondary' => 'nullable|string',
            'status' => 'required|in:active,inactive',
            'facebook' => 'nullable|url|max:255',
            'instagram' => 'nullable|url|max:255',
            'twitter' => 'nullable|url|max:255',
            'whatsapp' => 'nullable|string|max:255',
            'password' => 'nullable|string|min:6',
            'order_threshold' => 'nullable|numeric|min:0',
            'order_threshold_discount' => 'nullable|numeric|min:0',
            'order_threshold_discount_type' => 'required|in:fixed,percentage',
            'min_items_for_discount' => 'nullable|integer|min:0',
            'items_discount_amount' => 'nullable|numeric|min:0',
            'items_discount_type' => 'required|in:fixed,percentage',
        ];
    }

    /**
     * Get custom messages for validator errors.
     *
     * @return array
     */
    public function messages(): array
    {
        return [
            'name.required' => __('The vendor name is required.'),
            'email.required' => __('The email address is required.'),
            'email.email' => __('Please enter a valid email address.'),
            'email.unique' => __('This email is already registered.'),
            'slug.unique' => __('This slug is already in use.'),
            'password.min' => __('The password must be at least 6 characters.'),
            'status.required' => __('The status field is required.'),
            'logo.image' => __('The logo must be an image file.'),
            'logo.max' => __('The logo size cannot exceed 5MB.'),
            'about_image1.image' => __('The first about image must be an image file.'),
            'about_image2.image' => __('The second about image must be an image file.'),
        ];
    }
}
