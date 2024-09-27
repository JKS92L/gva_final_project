<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTeachersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('teachers', function (Blueprint $table) {
            $table->id(); // Auto-increment primary key
            $table->string('first_name');
            $table->string('last_name');
            $table->string('middle_name')->nullable(); // Optional middle name
            $table->string('gender');
            $table->date('date_of_birth');
            $table->string('email')->unique(); // Unique email
            $table->string('phone_number')->nullable();
            $table->text('address')->nullable();
            $table->string('city')->nullable();
            $table->string('state')->nullable();
            $table->string('country')->nullable();
            $table->string('photo')->nullable(); // Optional photo

            // Professional Information
            $table->string('employee_id')->unique(); // Internal employee ID
            $table->date('date_of_hire');
            $table->string('subject');
            $table->string('department');
            $table->string('position')->default('Teacher'); // Default role is Teacher
            $table->integer('years_of_experience')->default(0);
            $table->string('qualifications')->nullable();
            $table->string('certifications')->nullable();
            $table->string('class_assigned')->nullable();
            $table->string('school_branch')->nullable();

            // Login & Authentication
            $table->string('username')->unique();
            $table->string('password'); // Will store the hashed password
            $table->string('role')->default('teacher');
            $table->enum('status', ['active', 'inactive'])->default('active');
            $table->timestamp('last_login')->nullable();
            $table->string('password_reset_token')->nullable();

            // Availability
            $table->json('working_days')->nullable(); // Store available days in JSON
            $table->time('working_hours_start')->nullable();
            $table->time('working_hours_end')->nullable();

            // Miscellaneous
            $table->string('emergency_contact_name')->nullable();
            $table->string('emergency_contact_relation')->nullable();
            $table->string('emergency_contact_phone')->nullable();
            $table->string('national_id')->nullable(); // National Identification Number
            $table->string('bank_account_number')->nullable();

            $table->timestamps(); // Created at and Updated at
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('teachers');
    }
}
