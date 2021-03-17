<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBookingOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('booking_orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id');
            $table->foreignId('room_group_id');
            $table->date('date_from');
            $table->date('date_to');
            $table->unsignedInteger('num_of_night');
            $table->unsignedInteger('total_room');
            $table->unsignedInteger('total_adults');
            $table->unsignedInteger('total_children');
            $table->unsignedInteger('total_extra_bed');
            $table->decimal('room_price');
            $table->decimal('extra_bed_price');
            $table->decimal('total_room_amount');
            $table->decimal('total_extra_bed_amount');
            $table->decimal('total_room_cost');
            $table->boolean('site_booking')->default(0);
            $table->boolean('is_booked')->default(0);
            $table->boolean('is_paid')->default(0);
            $table->foreignId('status_id')->default(3);
            $table->foreignId('stage_id')->default(1);
            $table->decimal('total_amount');
            $table->string('razorpay_order_id')->nullable();
            $table->string('razorpay_payment_id')->nullable();
            $table->string('razorpay_signature')->nullable();
            $table->foreignId('created_by')->nullable();
            $table->softDeletes();

            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('room_group_id')->references('id')->on('room_groups');
            $table->foreign('status_id')->references('id')->on('statuses');
            $table->foreign('stage_id')->references('id')->on('stages');

            $table->timestamps();
        });
        DB::update("ALTER TABLE booking_orders AUTO_INCREMENT = 1020;");

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('booking_orders');
    }
}
