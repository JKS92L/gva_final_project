<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAcademicYearsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('academic_years', function (Blueprint $table) {
            $table->id();
            $table->string('academic_year')->comment('e.g. 2024-2025');
            $table->unsignedTinyInteger('term')->comment('1, 2, or 3');
            $table->date('start_date');
            $table->date('end_date');
            $table->boolean('status')->default(true)->comment('active or inactive');
            $table->unsignedBigInteger('created_by')->nullable(); // Foreign key to Users table
            $table->timestamps();

            // You can add foreign key constraints here if needed
            // $table->foreign('created_by')->references('id')->on('users')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('academic_years');
    }
}
