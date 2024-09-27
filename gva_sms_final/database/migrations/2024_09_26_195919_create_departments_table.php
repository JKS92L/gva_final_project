<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDepartmentsTable extends Migration
{
    public function up()
    {
        Schema::create('departments', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->string('code')->unique();  // Short code for the department
            $table->enum('status', ['active', 'inactive'])->default('active');  // Department status
            $table->timestamps();  // Created_at and updated_at
        });
    }

    public function down()
    {
        Schema::dropIfExists('departments');
    }
}
