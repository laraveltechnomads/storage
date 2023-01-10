<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateTariffMastersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tariff_masters', function (Blueprint $table) {
            $table->id();
            $table->string('tariff_code',16)->nullable();
            $table->string('description',100)->nullable();
            $table->integer('unit_id')->nullable();
            $table->string('startdate',100)->nullable();
            $table->string('enddate',100)->nullable();
            $table->integer('status')->comment('1:active,0:inactive')->nullable();
            $table->string('created_unit_id',100)->nullable();
            $table->string('updated_unit_id',100)->nullable();
            $table->string('added_by',100)->nullable();
            $table->string('added_on',100)->nullable();
            $table->string('added_date_time',100)->nullable();
            $table->string('added_utc_date_time',100)->nullable();
            $table->string('updated_by',100)->nullable();
            $table->string('updated_date_time',100)->nullable();
            $table->string('updated_utc_date_time',100)->nullable();
            $table->string('added_windows_login_name',100)->nullable();
            $table->string('update_windows_login_name',100)->nullable();
            $table->integer('synchronized')->nullable();
            $table->unsignedBigInteger('service_id')->nullable();            
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
        Schema::dropIfExists('tariff_masters');
    }
}
