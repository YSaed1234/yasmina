<?php

namespace Modules\Admin\Services;

use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleService
{
    public function getAllWithPermissions(array $filters = [])
    {
        $query = Role::with('permissions');

        if (!empty($filters['search'])) {
            $search = $filters['search'];
            $query->where('name', 'like', "%{$search}%");
        }

        return $query->paginate($filters['per_page'] ?? 10);
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
