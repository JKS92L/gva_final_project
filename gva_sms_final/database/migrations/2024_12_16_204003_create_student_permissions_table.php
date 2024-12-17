<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStudentPermissionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('student_permissions', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('student_id');
            $table->unsignedBigInteger('academic_term_id');
            $table->date('permission_start');
            $table->date('permission_end');
            $table->time('pickup_time');
            $table->enum('pickup_person', ['parent', 'other']);
            $table->string('other_name')->nullable();
            $table->string('other_nrc')->nullable();
            $table->string('other_contact')->nullable();
            $table->string('vehicle_reg')->nullable();
            $table->text('reason');
            $table->text('deputy_comment')->nullable();
            $table->timestamps();

            // Foreign keys
            $table->foreign('student_id')->references('id')->on('students')->onDelete('cascade');
            $table->foreign('academic_term_id')->references('id')->on('academic_terms')->onDelete('cascade');
        });
    }


    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('student_permissions');
    }
}
