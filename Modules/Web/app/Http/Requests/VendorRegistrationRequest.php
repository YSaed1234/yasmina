<?php

namespace Modules\Web\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class VendorRegistrationRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:vendors,email',
            'phone' => 'required|string',
            'phone_secondary' => 'nullable|string',
            'description' => 'nullable|string',
            'password' => 'required|string|min:6|confirmed',
            'logo' => 'nullable|image|max:2048',
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => __('The vendor name is required.'),
            'email.required' => __('The email address is required.'),
            'email.email' => __('Please enter a valid email address.'),
            'email.unique' => __('This email is already registered.'),
            'phone.required' => __('The phone number is required.'),
            'password.required' => __('A password is required.'),
            'password.min' => __('The password must be at least 6 characters.'),
            'password.confirmed' => __('The password confirmation does not match.'),
            'logo.image' => __('The logo must be an image file.'),
            'logo.max' => __('The logo size cannot exceed 2MB.'),
        ];
    }
}
