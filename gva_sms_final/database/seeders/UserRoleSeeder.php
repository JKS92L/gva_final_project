<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserRoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $roles = [
            ['role_name' => 'admin', 'description' => 'System administrator', 'status' => 'active'],
            ['role_name' => 'teacher', 'description' => 'Teacher in the school', 'status' => 'active'],
            ['role_name' => 'student', 'description' => 'Student enrolled in the school', 'status' => 'active'],
            ['role_name' => 'class teacher', 'description' => 'Teacher responsible for a class', 'status' => 'active'],
            ['role_name' => 'parent', 'description' => 'Parent or guardian of a student', 'status' => 'active'],
            ['role_name' => 'librarian', 'description' => 'Person managing the library', 'status' => 'inactive'],
            ['role_name' => 'shopkeeper', 'description' => 'Person managing the school shop', 'status' => 'inactive'],
            ['role_name' => 'nurse', 'description' => 'School nurse', 'status' => 'inactive'],
            ['role_name' => 'maintenance', 'description' => 'Maintenance staff', 'status' => 'inactive'],
            ['role_name' => 'patron-matron', 'description' => 'Patron or Matron of the boarding house', 'status' => 'active'],
            ['role_name' => 'boarding teacher', 'description' => 'Teacher in charge of the boarding students', 'status' => 'inactive'],
            ['role_name' => 'head of department', 'description' => 'Head of academic department', 'status' => 'inactive'],
            ['role_name' => 'CPD coordinator', 'description' => 'Continuing Professional Development coordinator', 'status' => 'inactive'],
            ['role_name' => 'alumni', 'description' => 'Former student (alumni)', 'status' => 'inactive'],
        ];

        DB::table('user_roles')->insert($roles);
    }
}
