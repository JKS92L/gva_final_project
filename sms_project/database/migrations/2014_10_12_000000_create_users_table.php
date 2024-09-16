<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('username')->unique();        // Unique username
            $table->string('email')->unique();           // Unique email
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');                  // Password field (hashing handled by Laravel)
            $table->string('first_name');                // First name
            $table->string('last_name');                 // Last name
            $table->string('phone')->nullable();         // Phone number (optional)
            $table->string('profile_image')->nullable(); // Profile image (optional)
            $table->string('ip_address')->nullable();    // IP address (optional for tracking)
            $table->boolean('active')->default(false);   // Activation status
            $table->timestamp('last_login')->nullable(); // Last login time (optional for tracking)
            $table->rememberToken();                     // Remember token for "remember me" functionality
            $table->timestamps();                        // Timestamps for created_at and updated_at
        });
    }


    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
