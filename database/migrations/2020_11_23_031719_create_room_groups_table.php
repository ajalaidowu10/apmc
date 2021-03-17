<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRoomGroupsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('room_groups', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->longText('descp');
            $table->decimal('room_price');
            $table->decimal('extra_bed_price');
            $table->foreignId('status_id')->default(1);
            $table->timestamps();
            $table->softDeletes();

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
        Schema::dropIfExists('room_groups');
    }
}
