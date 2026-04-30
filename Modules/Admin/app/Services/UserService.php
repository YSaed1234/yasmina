<?php

namespace Modules\Admin\Services;

use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserService
{
    public function getAllPaginated($limit = 10, array $filters = [])
    {
        $query = User::with('roles')->latest();

        if (!empty($filters['search'])) {
            $search = $filters['search'];
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%");
            });
        }

        return $query->paginate($limit);
    }

    public function create(array $data)
    {
        if (request()->hasFile('profile_image')) {
            $data['profile_image'] = request()->file('profile_image')->store('profiles', 'public');
        }

        $user = User::create([
            'role' => $data['role'],
            'name' => $data['name'],
            'email' => $data['email'],
            'phone' => $data['phone'] ?? null,
            'profile_image' => $data['profile_image'] ?? null,
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
            'phone' => $data['phone'] ?? $user->phone,
        ];

        if (request()->hasFile('profile_image')) {
            if ($user->profile_image) {
                \Illuminate\Support\Facades\Storage::disk('public')->delete($user->profile_image);
            }
            $updateData['profile_image'] = request()->file('profile_image')->store('profiles', 'public');
        }

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
