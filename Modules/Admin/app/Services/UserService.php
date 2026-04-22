<?php

namespace Modules\Admin\Services;

use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserService
{
    public function getAllPaginated($limit = 10)
    {
        return User::with('roles')->latest()->paginate($limit);
    }

    public function create(array $data)
    {
        $user = User::create([
            'role' => $data['role'],
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);

        $user->syncRoles([$data['role']]);
        return $user;
    }

    public function update(User $user, array $data)
    {
        $updateData = [
            'role' => $data['role'],
            'name' => $data['name'],
            'email' => $data['email'],
        ];

        if (!empty($data['password'])) {
            $updateData['password'] = Hash::make($data['password']);
        }

        $user->update($updateData);
        $user->syncRoles([$data['role']]);
        return $user;
    }

    public function delete(User $user)
    {
        if ($user->id === auth()->id()) {
            throw new \Exception(__('You cannot delete yourself.'));
        }

        return $user->delete();
    }
}
