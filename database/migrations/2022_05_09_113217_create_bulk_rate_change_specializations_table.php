<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBulkRateChangeSpecializationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bulk_rate_change_specializations', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('bulk_id')->nullable();
            $table->foreign('bulk_id')->references('id')->on('bulk_rate_changes')->onDelete('cascade');
            $table->unsignedBigInteger('s_id')->nullable();
            $table->foreign('s_id')->references('id')->on('specializations')->onDelete('cascade');
            $table->unsignedBigInteger('su_id')->nullable();
            $table->foreign('su_id')->references('id')->on('sub_specializations')->onDelete('cascade');
            $table->string('is_set_rate_for_all',10)->nullable();
            $table->string('is_percentage_rate',10)->nullable();
            $table->string('percentage_rate',10)->nullable();
            $table->string('amount_rate',10)->nullable();
            $table->string('operation_type',10)->nullable();
            $table->integer('status')->nullable();
            $table->string('synchronized',10)->nullable();
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
        Schema::dropIfExists('bulk_rate_change_specializations');
    }
}
