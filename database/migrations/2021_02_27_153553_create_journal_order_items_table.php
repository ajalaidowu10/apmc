<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateJournalOrderItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('journal_order_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('journal_order_id');
            $table->foreignId('acct_one_id');
            $table->foreignId('crdr_id');
            $table->decimal('amount');
            $table->string('descp');
            $table->boolean('del_record')->default(0);
            $table->timestamps();
            $table->softDeletes();
            $table->foreign('acct_one_id')->references('id')->on('accounts');
            $table->foreign('crdr_id')->references('id')->on('crdrs');
            $table->foreign('journal_order_id')->references('id')->on('journal_orders');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('journal_order_items');
    }
}
