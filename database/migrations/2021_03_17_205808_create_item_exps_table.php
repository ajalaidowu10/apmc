<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateItemExpsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('item_exps', function (Blueprint $table) {
            $table->id();
            $table->foreignId('item_id');
            $table->date('enter_date');
            $table->decimal('comm');
            $table->decimal('p_hamali');
            $table->decimal('b_hamali');
            $table->decimal('p_levy');
            $table->decimal('b_levy');
            $table->decimal('apmc');
            $table->decimal('map_levy', 10, 4);
            $table->decimal('discount');
            $table->decimal('tolai');
            $table->decimal('tds');
            $table->foreignId('company_id');
            $table->foreignId('finyear_id');
            $table->timestamps();
            $table->softDeletes();
            $table->foreignId('status_id')->default(1);
            $table->foreign('item_id')->references('id')->on('items');
            $table->foreign('status_id')->references('id')->on('statuses');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('item_exps');
    }
}
