<?php

namespace Modules\Admin\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateUserRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'phone' => ['required', 'string', 'regex:/^(\+20|0)?1[0125][0-9]{8}$|^(\+966|0)?5[0-9]{8}$/'],
            'password' => 'required|string|min:8|confirmed',
            'role' => 'required',
            'profile_image' => 'nullable|image|max:2048'
        ];
    }

    public function messages(): array
    {
        return [
            'phone.regex' => __('Please enter a valid Egyptian or Saudi phone number.')
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
