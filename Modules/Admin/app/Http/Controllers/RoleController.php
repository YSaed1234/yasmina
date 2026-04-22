<?php

namespace Modules\Admin\Http\Controllers;

use App\Http\Controllers\Controller;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Http\Request;

use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

class RoleController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return [
            new Middleware('permission:manage permissions'),
        ];
    }
    public function index()
    {
        $roles = Role::with('permissions')->get();
        return view('admin::roles.index', compact('roles'));
    }

    public function create()
    {
        $permissions = Permission::all()->groupBy(function($perm) {
            if (str_contains($perm->name, 'categories')) return 'Categories';
            if (str_contains($perm->name, 'products')) return 'Products';
            if (str_contains($perm->name, 'currencies')) return 'Currencies';
            if (str_contains($perm->name, 'contact requests')) return 'Contact Requests';
            if (str_contains($perm->name, 'permissions')) return 'System';
            return 'Other';
        });
        return view('admin::roles.create', compact('permissions'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:roles,name',
            'permissions' => 'required|array'
        ]);

        $role = Role::create(['name' => $request->name]);
        $role->syncPermissions($request->permissions);

        return redirect()->route('roles.index')->with('success', __('Role created successfully.'));
    }

    public function edit(Role $role)
    {
        $permissions = Permission::all()->groupBy(function($perm) {
            if (str_contains($perm->name, 'categories')) return 'Categories';
            if (str_contains($perm->name, 'products')) return 'Products';
            if (str_contains($perm->name, 'currencies')) return 'Currencies';
            if (str_contains($perm->name, 'contact requests')) return 'Contact Requests';
            if (str_contains($perm->name, 'permissions')) return 'System';
            return 'Other';
        });
        $rolePermissions = $role->permissions->pluck('name')->toArray();
        return view('admin::roles.edit', compact('role', 'permissions', 'rolePermissions'));
    }

    public function update(Request $request, Role $role)
    {
        $request->validate([
            'name' => 'required|unique:roles,name,' . $role->id,
            'permissions' => 'required|array'
        ]);

        $role->update(['name' => $request->name]);
        $role->syncPermissions($request->permissions);

        return redirect()->route('roles.index')->with('success', __('Role updated successfully.'));
    }

    public function destroy(Role $role)
    {
        $role->delete();
        return redirect()->route('roles.index')->with('success', __('Role deleted successfully.'));
    }
}
