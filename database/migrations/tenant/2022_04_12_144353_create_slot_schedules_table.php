<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateSlotSchedulesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::dropIfExists('slot_schedules'); 
        Schema::create('slot_schedules', function (Blueprint $table) {
            $table->id();
            $table->string('code')->nullable();
            $table->longText('description')->nullable();
            $table->time('start_time')->nullable();
            $table->time('end_time')->nullable();
            $table->tinyInteger('status')->default(1)->comment('1= active, 0=inactive');
            $table->unsignedBigInteger('created_unit_id')->nullable();
            $table->unsignedBigInteger('updated_unit_id')->nullable();
            $table->string('added_by')->nullable();
            $table->string('added_on')->nullable();
            $table->string('added_date_time')->nullable();
            $table->string('added_utc_date_time')->nullable();
            $table->string('added_windows_login_name')->nullable();
            $table->string('updated_by')->nullable();
            $table->string('updated_on')->nullable();
            $table->string('updated_date_time')->nullable();
            $table->timestamp('updated_utc_date_time')->nullable();            
            $table->string('updated_windows_login_name')->nullable();
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
        Schema::dropIfExists('slot_schedules');
    }
}
