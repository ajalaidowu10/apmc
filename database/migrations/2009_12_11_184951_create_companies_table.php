<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCompaniesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('companies', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->string('phone');
            $table->string('address');
            $table->string('invheader_path')->nullable();
            $table->string('invfooter_path')->nullable();
            $table->string('recheader_path')->nullable();
            $table->string('recfooter_path')->nullable();
            $table->foreignId('status_id')->default(1);
            $table->foreignId('created_by');
            $table->softDeletes();
            $table->timestamps();
            $table->foreign('created_by')->references('id')->on('admins');
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
        Schema::dropIfExists('companies');
    }
}
