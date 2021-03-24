<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePurchaseOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('purchase_orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('acct_id');
            $table->string('invoice_no')->nullable();
            $table->string('motor_no');
            $table->date('enter_date');
            $table->decimal('total_qty');
            $table->decimal('total_amount');
            $table->decimal('other_charges');
            $table->decimal('levy');
            $table->decimal('apmc');
            $table->decimal('map_levy');
            $table->decimal('comm');
            $table->decimal('tds');
            $table->foreignId('status_id')->default(1);
            $table->foreignId('created_by');
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('acct_id')->references('id')->on('accounts');
            $table->foreign('status_id')->references('id')->on('statuses');
            $table->foreign('created_by')->references('id')->on('admins');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('purchase_orders');
    }
}
