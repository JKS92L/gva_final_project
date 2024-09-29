
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBedspacesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bedspaces', function (Blueprint $table) {
            $table->id(); // Auto-incrementing ID
            $table->unsignedBigInteger('hostel_id'); // Foreign key for hostels
            $table->string('bedspace_no', 50); // Bedspace number (varchar)
            $table->timestamps(); // Laravel's default created_at and updated_at fields

            // Foreign key constraint
            $table->foreign('hostel_id')->references('hostel_id')->on('hostels')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('bedspaces');
    }
}
