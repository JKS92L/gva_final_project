<?php 
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateClassSubjectsTable extends Migration
{
/**
* Run the migrations.
*
* @return void
*/
public function up()
{
Schema::create('class_subjects', function (Blueprint $table) {
$table->id(); // Primary key
$table->foreignId('subject_id')->constrained('subjects')->onDelete('cascade'); // Foreign key for subject
$table->string('class_name'); // Class to which the subject belongs (e.g., Grade 10)
$table->integer('teacher_id')->nullable(); // Teacher responsible for the subject
$table->timestamps(); // Timestamps for created_at and updated_at
});
}

/**
* Reverse the migrations.
*
* @return void
*/
public function down()
{
Schema::dropIfExists('class_subjects');
}
}