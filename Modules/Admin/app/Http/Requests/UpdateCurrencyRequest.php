<?php

namespace Modules\Admin\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCurrencyRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $currencyId = $this->route('currency');
        return [
            'ar.name' => 'required|string|max:255',
            'en.name' => 'required|string|max:255',
            'code' => 'required|string|max:10|unique:currencies,code,' . $currencyId,
            'symbol' => 'required|string|max:10',
        ];
    }
}
