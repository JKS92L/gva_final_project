<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGradesTable extends Migration
{
    public function up()
    {
        Schema::create('grades', function (Blueprint $table) {
            $table->id();
            $table->integer('gradeno'); // Grade number (e.g., 10, 11, etc.)
            $table->string('class_name'); // Name of the class (e.g., "Form 1A")
            $table->string('section')->nullable(); // Optional section (e.g., "A", "B")
            $table->string('level')->nullable(); // Educational level (e.g., "Secondary", "Primary")
            $table->integer('capacity')->default(40); // Maximum capacity of students in the grade
            $table->enum('status', ['active', 'inactive'])->default('active'); // Active or inactive grade
            $table->timestamps(); // Created_at and updated_at columns
        });
    }

    public function down()
    {
        Schema::dropIfExists('grades');
    }
}
