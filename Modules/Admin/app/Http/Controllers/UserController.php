<?php

namespace Modules\Admin\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Modules\Admin\Http\Requests\CreateUserRequest;
use Modules\Admin\Http\Requests\UpdateUserRequest;
use Modules\Admin\Services\UserService;

class UserController extends Controller
{
    protected $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    public function index(\Illuminate\Http\Request $request)
    {
        $users = $this->userService->getAllPaginated(10, $request->all());
        return view('admin::users.index', compact('users'));
    }

    public function create()
    {
        $roles = Role::with('permissions')->get();
        return view('admin::users.create', compact('roles'));
    }

    public function store(CreateUserRequest $request)
    {
        $this->userService->create($request->validated());
        return redirect()->route('admin.users.index')->with('success', __('User created successfully.'));
    }

    public function edit(User $user)
    {
        $roles = Role::with('permissions')->get();
        return view('admin::users.edit', compact('user', 'roles'));
    }

    public function update(UpdateUserRequest $request, User $user)
    {
        $this->userService->update($user, $request->validated());
        return redirect()->route('admin.users.index')->with('success', __('User updated successfully.'));
    }

    public function destroy(User $user)
    {
        try {
            $this->userService->delete($user);
            return redirect()->route('users.index')->with('success', __('User deleted successfully.'));
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }
    public function search(\Illuminate\Http\Request $request)
    {
        $search = $request->get('q');
        $users = User::where('name', 'like', "%$search%")
            ->orWhere('email', 'like', "%$search%")
            ->limit(10)
            ->get(['id', 'name', 'email']);

        return response()->json($users);
    }
}
