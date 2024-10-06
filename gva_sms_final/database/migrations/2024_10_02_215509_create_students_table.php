<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStudentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('students', function (Blueprint $table) {
            $table->id(); // Auto-incrementing ID
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // Foreign key reference to users table
            $table->string('ecz_no')->unique(); // Examination number
            $table->foreignId('class_id')->constrained(); // Foreign key reference to classes table
            $table->foreignId('section_id')->constrained(); // Foreign key reference to sections table
            $table->string('firstname');
            $table->string('lastname');
            $table->string('other_name')->nullable();
            $table->enum('gender', ['male', 'female', 'other']);
            $table->date('dob'); // Date of birth
            $table->string('nrc_id_no')->unique(); // National Registration Card ID number
            $table->string('religion')->nullable(); // Religion
            $table->date('admission_date')->nullable(); // Admission date
            $table->string('medical_condition')->nullable(); // Medical condition
            $table->string('student_phot')->nullable(); // File path for student photo
            $table->string('hostel_name')->nullable(); // Hostel name
            $table->string('bedspaceSelect')->nullable(); // Bed space selection
            $table->string('hostel_supervisor')->nullable(); // Hostel supervisor
            $table->string('father_name')->nullable(); // Father's name
            $table->string('father_phone')->nullable(); // Father's phone number
            $table->string('father_occupation')->nullable(); // Father's occupation
            $table->string('father_email')->nullable(); // Father's email
            $table->string('father_address')->nullable(); // Father's address
            $table->string('mother_name')->nullable(); // Mother's name
            $table->string('mother_phone')->nullable(); // Mother's phone number
            $table->string('mother_occupation')->nullable(); // Mother's occupation
            $table->string('mother_email')->nullable(); // Mother's email
            $table->string('mother_address')->nullable(); // Mother's address
            $table->json('fee_session_group_id')->nullable(); // Fee session group ID(s)
            $table->string('email')->unique(); // Student email
            $table->string('phone_number')->nullable(); // Student phone number
            $table->string('username')->unique(); // Username
            $table->timestamps(); // Created at and updated at timestamps
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('students');
    }
}
