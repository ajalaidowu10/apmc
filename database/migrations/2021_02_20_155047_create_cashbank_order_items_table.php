<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCashbankOrderItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cashbank_order_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('cashbank_order_id');
            $table->foreignId('acct_two_id');
            $table->decimal('amount');
            $table->string('descp');
            $table->boolean('del_record')->default(0);
            $table->timestamps();
            $table->softDeletes();
            $table->foreign('acct_two_id')->references('id')->on('accounts');
            $table->foreign('cashbank_order_id')->references('id')->on('cashbank_orders');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cashbank_order_items');
    }
}
