<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{
    public function run()
    {
        // Define user data with roles
        $usersData = [
            [
                'role' => 'admin',  // Role assignment (adjust as needed)
                'username' => 'adminuser',
                'first_name' => 'Admin',
                'last_name' => 'User',
                'phone' => '1234567890',
                'profile_image' => null,  // No image provided
                'email' => 'admin@example.com',
                'password' => Hash::make('password'), // Password should be hashed
                'ip_address' => request()->ip(),
                'active' => 1,
                'last_login' => now(),
                'remember_token' => Str::random(10)
                
            ]
        ];

        // Insert users and assign roles
        foreach ($usersData as $data) {
            // Create or fetch the user
            $user = User::updateOrCreate([
                'email' => $data['email']
            ], [
                'username' => $data['username'],
                'first_name' => $data['first_name'],
                'last_name' => $data['last_name'],
                'phone' => $data['phone'],
                'profile_image' => $data['profile_image'],
                'email' => $data['email'],
                'password' => $data['password'],
                'ip_address' => $data['ip_address'],
                'active' => $data['active'],
                'last_login' => $data['last_login'],
                'remember_token' => $data['remember_token'],
            ]);

            // Assign the role to the user
            $user->assignRole($data['role']);

           
        }
    }
}
