<?php

namespace Modules\Admin\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateOrderStatusRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'status' => ['required', new \Illuminate\Validation\Rules\Enum(\App\Enums\OrderStatus::class)],
            'rejection_reason' => ['required_if:status,cancelled', 'nullable', 'string', 'max:1000'],
        ];
    }
}
