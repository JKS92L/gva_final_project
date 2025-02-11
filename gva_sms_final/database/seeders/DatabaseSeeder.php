<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Database\Seeders\UserRoleSeeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create(); UpdateUserRolesTable
        // $this->call(UserRoleSeeder::class);
         $this->call(UserRoleSeeder::class);
    }
}
