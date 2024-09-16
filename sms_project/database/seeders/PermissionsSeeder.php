<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Illuminate\Foundation\Auth\User;
use Spatie\Permission\Models\Permission;

class PermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Ensure RolesAndPermissionsSeeder has been run
        $this->call(RolesAndPermissionsSeeder::class);

        // Fetch roles and permissions
        $adminRole = Role::where('name', 'admin')->first();
        $userRole = Role::where('name', 'user')->first();

        $permissions = Permission::all();

        // Assign permissions to roles
        $adminRole->givePermissionTo($permissions);
        $userRole->givePermissionTo($permissions->where('name', 'view dashboard'));

        // Assign roles to users
        $adminUser = User::where('email', 'admin@example.com')->first();
        $adminUser->assignRole($adminRole);

        // $normalUser = User::where('email', 'user@example.com')->first();
        // $normalUser->assignRole($userRole);

        // Alternatively, assign permissions directly to users
        $adminUser->givePermissionTo($permissions);
    }
}
