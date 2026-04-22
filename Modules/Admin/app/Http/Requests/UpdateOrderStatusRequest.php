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
            'status' => 'required|string|in:new,processing,shipped,delivered,cancelled',
            'payment_status' => 'required|string|in:pending,paid,failed'
        ];
    }
}
