<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFinancialYearsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('financial_years', function (Blueprint $table) {
            $table->id();
            $table->foreignId('company_id');
            $table->date('from_date');
            $table->date('to_date');
            $table->foreignId('status_id')->default(1);
            $table->foreignId('created_by');
            $table->timestamps();
            $table->softDeletes();
            $table->foreign('created_by')->references('id')->on('admins');
            $table->foreign('status_id')->references('id')->on('statuses');
            $table->foreign('company_id')->references('id')->on('companies');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('financial_years');
    }
}
