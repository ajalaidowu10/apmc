<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateServiceOrderItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('service_order_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('service_order_id');
            $table->foreignId('service_id');
            $table->decimal('qty');
            $table->decimal('service_price');
            $table->decimal('amount');
            $table->boolean('del_record')->default(0);
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('service_order_id')->references('id')->on('service_orders');
            $table->foreign('service_id')->references('id')->on('services');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('service_order_items');
    }
}
