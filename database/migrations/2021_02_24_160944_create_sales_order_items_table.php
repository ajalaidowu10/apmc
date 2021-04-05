<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSalesOrderItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sales_order_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('sales_order_id');
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
            $table->longText('item_exp_object');
            $table->boolean('del_record')->default(0);
            $table->foreignId('company_id');
            $table->foreignId('finyear_id');
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('sales_order_id')->references('id')->on('sales_orders');
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
        Schema::dropIfExists('sales_order_items');
    }
}
