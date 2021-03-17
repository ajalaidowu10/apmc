<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBookingOrderItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('booking_order_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('booking_order_id');
            $table->unsignedInteger('dummy_room_id');
            $table->unsignedInteger('adults');
            $table->unsignedInteger('extra_bed');
            $table->unsignedInteger('children');
            $table->unsignedInteger('child_age');
            $table->foreignId('status_id')->default(3);
            $table->foreignId('room_id')->nullable();
            $table->dateTime('time_in')->nullable();
            $table->dateTime('time_out')->nullable();
            $table->decimal('room_cost')->nullable();
            $table->decimal('room_gst')->nullable();
            $table->decimal('total_amount')->nullable();
            $table->timestamps();
            $table->softDeletes();
            $table->foreign('booking_order_id')->references('id')->on('booking_orders');
            $table->foreign('status_id')->references('id')->on('statuses');
            $table->foreign('room_id')->references('id')->on('rooms');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('booking_order_items');
    }
}
