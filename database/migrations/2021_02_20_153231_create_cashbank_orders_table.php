<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCashbankOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cashbank_orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('cashbank_type_id');
            $table->foreignId('payment_type_id');
            $table->foreignId('acct_one_id');
            $table->decimal('total_amount');
            $table->date('enter_date');
            $table->foreignId('status_id')->default(1);
            $table->foreignId('created_by');
            $table->foreign('cashbank_type_id')->references('id')->on('cashbank_types');
            $table->foreign('payment_type_id')->references('id')->on('payment_types');
            $table->foreign('acct_one_id')->references('id')->on('accounts');
            $table->foreign('status_id')->references('id')->on('statuses');
            $table->foreign('created_by')->references('id')->on('admins');
            $table->foreignId('company_id');
            $table->foreignId('finyear_id');
            $table->timestamps();
            $table->softDeletes();

            
        });

        DB::update("ALTER TABLE cashbank_orders AUTO_INCREMENT = 1001;");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cashbank_orders');
    }
}
