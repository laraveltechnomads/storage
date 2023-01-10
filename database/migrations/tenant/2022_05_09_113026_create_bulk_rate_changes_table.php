<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBulkRateChangesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bulk_rate_changes', function (Blueprint $table) {
            $table->id();
            $table->string('is_applicable',16)->nullable();
            $table->date('effective_date')->nullable();
            $table->string('is_freeze',16)->nullable();
            $table->integer('status')->comment('0:Inactive,1:Active')->nullable();
            $table->string('is_closed',16)->nullable();
            $table->string('created_unit_id',20)->nullable();
            $table->string('added_by',100)->nullable();
            $table->string('added_on',100)->nullable();
            $table->string('added_date_time',50)->nullable();
            $table->string('added_utc_date_time',50)->nullable();
            $table->string('updated_unit_id',20)->nullable();
            $table->string('updated_by',100)->nullable();
            $table->string('updated_on',100)->nullable();
            $table->string('updated_date_time',50)->nullable();
            $table->string('updated_utc_date_time',50)->nullable();
            $table->string('added_windows_login_name',20)->nullable();
            $table->string('update_windows_login_name',20)->nullable();
            $table->string('synchronized',16)->nullable();
            $table->string('remark')->nullable();
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
        Schema::dropIfExists('bulk_rate_changes');
    }
}
