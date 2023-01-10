<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBulkRateChangeTarrifsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bulk_rate_change_tarrifs', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('bulk_id')->nullable();
            $table->foreign('bulk_id')->references('id')->on('bulk_rate_changes')->onDelete('cascade');
            $table->unsignedBigInteger('t_id')->nullable();
            $table->foreign('t_id')->references('id')->on('tariff_masters')->onDelete('cascade');
            $table->integer('status')->comment('0:Inactive,1:Active')->nullable();
            $table->string('created_unit_id',50)->nullable();
            $table->string('added_by',50)->nullable();
            $table->string('added_on',50)->nullable();
            $table->string('added_date_time',50)->nullable();
            $table->string('added_utc_date_time',50)->nullable();
            $table->string('updated_unit_id',50)->nullable();
            $table->string('updated_by',50)->nullable();
            $table->string('updated_on',50)->nullable();
            $table->string('updated_date_time',50)->nullable();
            $table->string('updated_utc_date_time',50)->nullable();
            $table->string('added_windows_login_name',50)->nullable();
            $table->string('update_windows_login_name',50)->nullable();
            $table->string('synchronized',50)->nullable();
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
        Schema::dropIfExists('bulk_rate_change_tarrifs');
    }
}
