<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateCoupleLinksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('couple_links', function (Blueprint $table) {
            $table->id();
            $table->integer('patient_id')->nullable();
            $table->integer('patient_unit_id')->nullable();
            $table->integer('spouse_id')->nullable();
            $table->integer('spouse_unit_id')->nullable();
            $table->integer('status')->comment('1:Active,0:Inactive')->nullable();
            $table->integer('created_unit_id')->nullable();
            $table->integer('updated_unit_id')->nullable();
            $table->string('added_by')->nullable();
            $table->string('added_on',20)->nullable();
            $table->datetime('added_date_time')->nullable();
            $table->datetime('added_utc_data_time')->nullable();
            $table->string('added_windows_login_name',50)->nullable();
            $table->string('updated_by',50)->nullable();
            $table->string('updated_on',50)->nullable();
            $table->datetime('updated_date_time')->nullable();
            $table->datetime('updated_utc_data_time')->nullable();
            $table->string('update_windows_login_name',50)->nullable();
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
        Schema::dropIfExists('couple_links');
    }
}
