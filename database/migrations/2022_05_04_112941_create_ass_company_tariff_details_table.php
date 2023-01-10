<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateAssCompanyTariffDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ass_company_tariff_details', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('comp_ass_id')->nullable();
            $table->foreign('comp_ass_id')->references('id')->on('company_associate_masters')->onDelete('cascade');
            $table->unsignedBigInteger('ct_id')->nullable();
            $table->foreign('ct_id')->references('id')->on('tariff_masters')->onDelete('cascade');
            $table->integer('status')->comment('1:Active,0:Inactive')->nullable();
            $table->string('created_unit_id',16)->nullable();
            $table->string('updated_unit_id',16)->nullable();
            $table->string('added_by',16)->nullable();
            $table->string('added_on',16)->nullable();
            $table->string('added_date_time',16)->nullable();
            $table->string('updated_by',16)->nullable();
            $table->string('updated_on',16)->nullable();
            $table->string('updated_date_time',16)->nullable();
            $table->string('added_windows_login_name',16)->nullable();
            $table->string('update_windows_login_name',16)->nullable();
            $table->string('synchronized',16)->nullable();
            $table->timestamp('created_at')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->timestamp('updated_at')->nullable()->default(DB::raw('CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP'));
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ass_company_tariff_details');
    }
}
