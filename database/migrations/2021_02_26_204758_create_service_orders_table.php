<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateServiceOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('service_orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('cus_acct_id');
            $table->date('enter_date');
            $table->decimal('total_qty');
            $table->decimal('total_amount');
            $table->string('descp');
            $table->foreignId('status_id')->default(1);
            $table->foreignId('created_by');
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('cus_acct_id')->references('id')->on('accounts');
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
        Schema::dropIfExists('service_orders');
    }
}
