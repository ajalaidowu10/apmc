<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGroupcodesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('groupcodes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('parent_groupcode_id');
            $table->string('name');
            $table->string('descp')->default('');
            $table->boolean('is_visible')->default(1);
            $table->softDeletes();
            $table->foreignId('created_by');
            $table->timestamps();
            $table->foreignId('status_id');
            $table->foreignId('company_id')->nullable();
            
            $table->foreign('parent_groupcode_id')->references('id')->on('parent_groupcodes');
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
        Schema::dropIfExists('groupcodes');
    }
}
