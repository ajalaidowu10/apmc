<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRoomGroupsPictures extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('room_groups_pictures', function (Blueprint $table) {
            $table->foreignId('room_group_id');
            $table->foreignId('picture_id');

            //SETTING THE PRIMARY KEYS
            $table->primary(['room_group_id', 'picture_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('room_groups_pictures');
    }
}
