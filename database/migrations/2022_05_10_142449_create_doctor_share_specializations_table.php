<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDoctorShareSpecializationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('doctor_share_specializations', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('doc_share_id')->nullable();
            $table->foreign('doc_share_id')->references('id')->on('doctor_shares')->onDelete('cascade');
            $table->unsignedBigInteger('doc_id')->nullable();
            $table->foreign('doc_id')->references('id')->on('doctors')->onDelete('cascade');
            $table->unsignedBigInteger('t_id')->nullable();
            $table->foreign('t_id')->references('id')->on('tariff_masters')->onDelete('cascade');
            $table->unsignedBigInteger('s_id')->nullable();
            $table->foreign('s_id')->references('id')->on('specializations')->onDelete('cascade');
            $table->unsignedBigInteger('su_id')->nullable();
            $table->foreign('su_id')->references('id')->on('sub_specializations')->onDelete('cascade');
            $table->string('fname')->nullable();
            $table->string('lname')->nullable();
            $table->string('share_pr',50)->nullable();
            $table->string('apply_all_subsup',50)->nullable();
            $table->string('apply_to_all_service',50)->nullable();
            $table->string('apply_to_all_doc',50)->nullable();
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
        Schema::dropIfExists('doctor_share_specializations');
    }
}
