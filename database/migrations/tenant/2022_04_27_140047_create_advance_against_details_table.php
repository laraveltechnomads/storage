<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateAdvanceAgainstDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('advance_against_details', function (Blueprint $table) {
            $table->id();
            $table->integer('adv_ag_code')->nullable();
            $table->string('description',10)->nullable();
            $table->integer('status')->comment('0:Inactive,1:Active')->nullable();
            $table->string('created_unit_id',10)->nullable();
            $table->string('updated_unit_id',10)->nullable();
            $table->string('added_by',10)->nullable();
            $table->string('added_on',10)->nullable();
            $table->string('added_date_time',10)->nullable();
            $table->string('Added_utc_date_time',10)->nullable();
            $table->string('updated_by',10)->nullable();
            $table->string('updated_on',10)->nullable();
            $table->string('updated_date_time',10)->nullable();
            $table->string('updated_utc_date_time',10)->nullable();
            $table->string('added_windows_login_name',10)->nullable();
            $table->string('update_windows_login_name',10)->nullable();
            $table->integer('synchronized')->nullable();
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
        Schema::dropIfExists('advance_against_details');
    }
}
