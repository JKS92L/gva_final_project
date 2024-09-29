<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateExamResultsTable extends Migration
{
    public function up()
    {
        Schema::create('exam_results', function (Blueprint $table) {
            $table->id('result_id'); // Primary key
            $table->foreignId('exam_id'); //->constrained('exams')->onDelete('cascade'); // Foreign key to Exams
            $table->foreignId('student_id');//->constrained('students')->onDelete('cascade'); // Foreign key to Students
            $table->foreignId('academic_year_id'); //->constrained('academic_years')->onDelete('cascade'); // Foreign key to Academic_Years
            $table->tinyInteger('term')->unsigned(); // Reference to term number
            $table->decimal('marks_obtained', 5, 2); // Marks obtained, allowing for decimal values
            $table->foreignId('grade_id'); //->constrained('grades')->onDelete('cascade'); // Foreign key to Grades
            $table->text('remarks')->nullable(); // Remarks
            $table->string('status')->default('active'); // Status, e.g., active or inactive
            $table->timestamps(); // Created at and updated at fields
        });
    }

    public function down()
    {
        Schema::dropIfExists('exam_results'); // Drop the table if it exists
    }
}
