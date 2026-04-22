<?php

namespace Modules\Admin\Services;

use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleService
{
    public function getAllWithPermissions()
    {
        return Role::with('permissions')->get();
    }

    public function getGroupedPermissions()
    {
        return Permission::all()->groupBy(function($perm) {
            if (str_contains($perm->name, 'categories')) return 'Categories';
            if (str_contains($perm->name, 'products')) return 'Products';
            if (str_contains($perm->name, 'currencies')) return 'Currencies';
            if (str_contains($perm->name, 'contact requests')) return 'Contact Requests';
            if (str_contains($perm->name, 'users')) return 'Users';
            if (str_contains($perm->name, 'permissions')) return 'System';
            return 'Other';
        });
    }

    public function create(array $data)
    {
        $role = Role::create(['name' => $data['name']]);
        if (!empty($data['permissions'])) {
            $role->syncPermissions($data['permissions']);
        }
        return $role;
    }

    public function update(Role $role, array $data)
    {
        $role->update(['name' => $data['name']]);
        if (isset($data['permissions'])) {
            $role->syncPermissions($data['permissions']);
        }
        return $role;
    }

    public function delete(Role $role)
    {
        return $role->delete();
    }
}
