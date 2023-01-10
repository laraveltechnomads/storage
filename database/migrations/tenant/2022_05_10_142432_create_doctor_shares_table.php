<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDoctorSharesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('doctor_shares', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('doc_id')->nullable();
            $table->foreign('doc_id')->references('id')->on('doctors')->onDelete('cascade');
            $table->integer('status')->comment('1:Active,0:Inactive')->default(1)->nullable();
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
        Schema::dropIfExists('doctor_shares');
    }
}
