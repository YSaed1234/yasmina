<?php

namespace Modules\Admin\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateRoleRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $roleId = $this->route('role')->id ?? $this->route('role');

        return [
            'name' => 'required|unique:roles,name,' . $roleId,
            'permissions' => 'nullable|array',
            'permissions.*' => 'string'
        ];
    }
}
