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
        ];

        foreach ($permissions as $permission) {
            Permission::create(['name' => $permission]);
        }

        // Create Roles and Assign Permissions
        $adminRole = Role::create(['name' => 'admin']);
        $adminRole->givePermissionTo(Permission::all());

        $editorRole = Role::create(['name' => 'editor']);
        $editorRole->givePermissionTo([
            'view categories',
            'edit categories',
            'view products',
            'edit products',
            'view currencies'
        ]);

        // Create Admin User
        $admin = User::create([
            'name' => 'Admin Yasmina',
            'email' => 'admin@yasmina.com',
            'password' => Hash::make('password'),
            'role' => 'admin', // for the custom column we added earlier
        ]);
        $admin->assignRole($adminRole);
    }
}
