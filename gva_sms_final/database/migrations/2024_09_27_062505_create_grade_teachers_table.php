<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGradeTeachersTable extends Migration
{
    public function up()
    {
        Schema::create('grade_teachers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade'); // Foreign key to users table
            $table->foreignId('grade_id')->constrained('grades')->onDelete('cascade'); // Foreign key to grades table
            $table->year('academic_year'); // Academic year (e.g., 2023)
            $table->date('date_assigned')->nullable(); // Date the teacher was assigned to the grade
            $table->string('remarks')->nullable(); // Any additional remarks about the teacher's role
            $table->boolean('active')->default(true); // Active or inactive status
            $table->timestamps(); // Created_at and updated_at columns
        });
    }

    public function down()
    {
        Schema::dropIfExists('grade_teachers');
    }
}
