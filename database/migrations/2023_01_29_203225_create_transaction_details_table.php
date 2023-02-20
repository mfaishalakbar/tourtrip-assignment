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
        Schema::create('transaction_details', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('transaction_id');
            $table->unsignedBigInteger('trip_id')->nullable();
            $table->unsignedBigInteger('hotel_id')->nullable();
            $table->date('start_date');
            $table->date('end_date');
            $table->bigInteger('price');
            $table->bigInteger('total_price');
            $table->timestamps();
            $table->softDeletes();
            $table->foreign('transaction_id')->references('id')->on('transactions')->onDelete('no action');
            $table->foreign('trip_id')->references('id')->on('trips')->onDelete('no action');
            $table->foreign('hotel_id')->references('id')->on('hotels')->onDelete('no action');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('transaction_details');
    }
};
