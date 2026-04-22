<?php

namespace Modules\Admin\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreCategoryRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'ar.name' => 'required|string|max:255',
            'en.name' => 'required|string|max:255',
            'rank' => 'nullable|integer',
        ];
    }
}
