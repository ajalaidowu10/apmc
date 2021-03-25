<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePurchaseOrderItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('purchase_order_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('purchase_order_id');
            $table->foreignId('item_id');
            $table->decimal('qty');
            $table->decimal('grwt');
            $table->decimal('rate');
            $table->decimal('amount');
            $table->decimal('levy');
            $table->decimal('map_levy');
            $table->decimal('apmc');
            $table->decimal('comm');
            $table->decimal('tds');
            $table->decimal('final_amount');
            $table->boolean('del_record')->default(0);
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('purchase_order_id')->references('id')->on('purchase_orders');
            $table->foreign('item_id')->references('id')->on('items');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('purchase_order_items');
    }
}
