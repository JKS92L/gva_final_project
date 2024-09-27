<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHodsTable extends Migration
{
    public function up()
    {
        Schema::create('hods', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');  // References the user table
            $table->foreignId('department_id')->constrained('departments')->onDelete('cascade');  // References the department table
            $table->date('date_appointed');  // Date of appointment
            $table->integer('term_duration')->nullable();  // Term duration (in months or years)
            $table->text('notes')->nullable();  // Additional notes about the HOD appointment
            $table->boolean('active')->default(true);  // Whether the HOD is still active
            $table->timestamps();  // Created_at and updated_at
        });
    }

    public function down()
    {
        Schema::dropIfExists('hods');
    }
}
