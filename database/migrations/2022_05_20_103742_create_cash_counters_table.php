<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CreateCashCountersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cash_counters', function (Blueprint $table) {
            $table->id();
            $table->string('cash_counter_code', 32)->nullable();
            $table->longText('description')->nullable();
            $table->tinyInteger('status')->default(1)->comment('1= active, 0=inactive');
            $table->unsignedBigInteger('created_unit_id')->nullable();
            $table->unsignedBigInteger('updated_unit_id')->nullable();
            $table->string('added_by')->nullable();
            $table->string('added_on')->nullable();
            $table->timestamp('added_date_time')->nullable();
            $table->timestamp('added_utc_date_time')->nullable();
            $table->string('updated_by')->nullable();
            $table->string('updated_on')->nullable();
            $table->timestamp('updated_date_time')->nullable();
            $table->timestamp('updated_utc_date_time')->nullable();
            $table->string('added_windows_login_name')->nullable();
            $table->string('update_windows_login_name')->nullable();

            $table->tinyInteger('synchronized')->default(1)->comment('1= active, 0=inactive');
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
        Schema::dropIfExists('cash_counters');
    }
}
