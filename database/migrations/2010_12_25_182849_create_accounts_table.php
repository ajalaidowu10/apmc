<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAccountsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('accounts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('account_type_id');
            $table->foreignId('status_id')->default(1);
            $table->string('name');
            $table->decimal('opening_bal')->default(0);
            $table->foreignId('crdr_id');
            $table->foreignId('groupcode_id');
            $table->integer('is_visible')->default(1);
            $table->foreignId('created_by')->nullable();
            $table->softDeletes();
            $table->timestamps();

            $table->foreign('account_type_id')->references('id')->on('account_types');
            $table->foreign('status_id')->references('id')->on('statuses');
            $table->foreign('crdr_id')->references('id')->on('crdrs');
            $table->foreign('groupcode_id')->references('id')->on('groupcodes');
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
        Schema::dropIfExists('accounts');
    }
}
