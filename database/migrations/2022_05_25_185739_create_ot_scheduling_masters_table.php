<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateOtSchedulingMastersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ot_scheduling_masters', function (Blueprint $table) {
            $table->id();
            $table->string('code', 10)->nullable();
            $table->unsignedBigInteger('ot_id')->nullable();
            $table->unsignedBigInteger('ot_table_id')->nullable();
            $table->unsignedBigInteger('day_id')->nullable();
            $table->unsignedBigInteger('schedule_id')->nullable();
            $table->time('from_time')->nullable();
            $table->time('to_time')->nullable();
            $table->tinyInteger('status')->default(1)->comment('1=active, 0=inactive');
            $table->timestamp('created_at')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->timestamp('updated_at')->nullable()->default(DB::raw('CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP'));
            $table->foreign('ot_id')->references('id')->on('ot_masters');
            $table->foreign('ot_table_id')->references('id')->on('ot_table_masters');
            $table->foreign('day_id')->references('id')->on('day_masters');
            $table->foreign('schedule_id')->references('id')->on('schedules');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ot_scheduling_masters');
    }
}
