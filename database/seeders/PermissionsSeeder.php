<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class PermissionsSeeder extends Seeder
{
    public function run(): void
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // Create Permissions
        $permissions = [
            'manage categories',
            'view categories',
            'create categories',
            'edit categories',
            'delete categories',

            'manage products',
            'view products',
            'create products',
            'edit products',
            'delete products',

            'manage currencies',
            'view currencies',
            'create currencies',
            'edit currencies',
            'delete currencies',

            'manage permissions',
            'manage users',
            'manage orders',
            'manage contact requests',
            'manage addresses',
            'manage coupons',
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }

        // Create Roles and Assign Permissions
        $adminRole = Role::firstOrCreate(['name' => 'admin']);
        $adminRole->givePermissionTo(Permission::all());

        $editorRole = Role::firstOrCreate(['name' => 'editor']);
        $editorRole->givePermissionTo([
            'view categories',
            'edit categories',
            'view products',
            'edit products',
            'view currencies'
        ]);

        // Create Admin User
        $admin = User::firstOrCreate(
            ['email' => 'admin@yasmina.com'],
            [
                'name' => 'Admin Yasmina',
                'password' => Hash::make('password'),
                'role' => 'admin',
            ]
        );
        $admin->assignRole($adminRole);
    }
}
