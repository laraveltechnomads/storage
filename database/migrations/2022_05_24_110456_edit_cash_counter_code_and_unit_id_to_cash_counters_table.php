<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class EditCashCounterCodeAndUnitIdToCashCountersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('cash_counters', function (Blueprint $table) {
            $table->renameColumn('cash_counter_code', 'code');
            $table->unsignedBigInteger('unit_id')->nullable()->after('created_at');
            $table->foreign('unit_id')->references('id')->on('units');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('cash_counters', function (Blueprint $table) {
            $table->renameColumn('code', 'cash_counter_code');
            $table->dropForeign(['unit_id']);
            $table->dropColumn(['unit_id']);
            
        });
    }
}
