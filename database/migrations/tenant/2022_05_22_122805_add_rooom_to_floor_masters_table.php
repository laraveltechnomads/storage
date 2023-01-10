<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRooomToFloorMastersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasColumn('floor_masters', 'room_amenities')) {
            Schema::table('floor_masters', function (Blueprint $table) {
                $table->text('room_amenities')->nullable()->after('block_id');
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('floor_masters', function (Blueprint $table) {
            //
        });
    }
}
