<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order', function (Blueprint $table) {
            $table->id();
            $table->integer('customer_id'); // Changed from int to integer
            $table->integer('reference_number'); // Changed from int to integer
            $table->double('original_price');
            $table->double('selling_price');
            $table->timestamps();
            $table->softDeletes(); // Adding soft delete column
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('order');
    }
};
