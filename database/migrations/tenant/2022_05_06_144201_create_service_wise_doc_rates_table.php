<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateServiceWiseDocRatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('service_wise_doc_rates', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('ser_rate_id')->nullable();
            $table->foreign('ser_rate_id')->references('id')->on('service_class_rate_details')->onDelete('cascade');
            $table->unsignedBigInteger('doc_cat_id')->nullable();
            $table->foreign('doc_cat_id')->references('id')->on('doctor_categories')->onDelete('cascade');
            $table->unsignedBigInteger('ser_id')->nullable();
            $table->foreign('ser_id')->references('id')->on('service_masters')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('service_wise_doc_rates');
    }
}
