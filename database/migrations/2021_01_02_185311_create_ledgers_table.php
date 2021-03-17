<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;


class CreateLedgersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ledgers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tran_id');
            $table->foreignId('transactype_id');
            $table->foreignId('acct_one_id');
            $table->date('enter_date');
            $table->foreignId('acct_two_id')->nullable();
            $table->decimal('amount');
            $table->foreignId('crdr_id');
            $table->string('descp');
            $table->boolean('is_visible')->default(1);
            $table->timestamps();
            $table->foreignId('created_by')->nullable();

            $table->foreign('transactype_id')->references('id')->on('transactypes');
            $table->foreign('acct_one_id')->references('id')->on('accounts');
            $table->foreign('acct_two_id')->references('id')->on('accounts');
            $table->foreign('crdr_id')->references('id')->on('crdrs');
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
        Schema::dropIfExists('ledgers');
    }
}
