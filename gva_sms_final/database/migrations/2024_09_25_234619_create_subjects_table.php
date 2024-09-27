<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSubjectsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('subjects', function (Blueprint $table) {
            $table->id(); // Primary key
            $table->string('name'); // Name of the subject
            $table->string('subject_code')->unique(); // Unique subject code
            $table->string('department'); // Department to which the subject belongs
            $table->boolean('active')->default(true); // Subject status (active or inactive)
            $table->text('description')->nullable(); // Description of the subject
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
        Schema::dropIfExists('subjects');
    }
}
