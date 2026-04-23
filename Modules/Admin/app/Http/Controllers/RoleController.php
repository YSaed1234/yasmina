<?php

namespace Modules\Admin\Http\Controllers;

use App\Http\Controllers\Controller;
use Spatie\Permission\Models\Role;
use Modules\Admin\Http\Requests\StoreRoleRequest;
use Modules\Admin\Http\Requests\UpdateRoleRequest;
use Modules\Admin\Services\RoleService;

use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

class RoleController extends Controller implements HasMiddleware
{
    protected $roleService;

    public function __construct(RoleService $roleService)
    {
        $this->roleService = $roleService;
    }

    public static function middleware(): array
    {
        return [
            new Middleware('permission:manage permissions'),
        ];
    }

    public function index(\Illuminate\Http\Request $request)
    {
        $roles = $this->roleService->getAllWithPermissions($request->all());
        return view('admin::roles.index', compact('roles'));
    }

    public function create()
    {
        $permissions = $this->roleService->getGroupedPermissions();
        return view('admin::roles.create', compact('permissions'));
    }

    public function store(StoreRoleRequest $request)
    {
        $this->roleService->create($request->validated());
        return redirect()->route('admin.roles.index')->with('success', __('Role created successfully.'));
    }

    public function edit(Role $role)
    {
        $permissions = $this->roleService->getGroupedPermissions();
        $rolePermissions = $role->permissions->pluck('name')->toArray();
        return view('admin::roles.edit', compact('role', 'permissions', 'rolePermissions'));
    }

    public function update(UpdateRoleRequest $request, Role $role)
    {
        $this->roleService->update($role, $request->validated());
        return redirect()->route('admin.roles.index')->with('success', __('Role updated successfully.'));
    }

    public function destroy(Role $role)
    {
        $this->roleService->delete($role);
        return redirect()->route('admin.roles.index')->with('success', __('Role deleted successfully.'));
    }
}
