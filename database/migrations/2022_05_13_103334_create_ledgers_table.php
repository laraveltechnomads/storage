<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLedgersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ledgers', function (Blueprint $table) {
            $table->id();
            $table->string('general_ledger')->nullable();
            $table->timestamps();
        });

        Schema::table('item_groups', function (Blueprint $table) {
            $table->unsignedBigInteger('ledgers_id')->after('unit_id')->nullable();
            $table->foreign('ledgers_id')->references('id')->on('ledgers');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('item_groups', function (Blueprint $table) {
            $table->dropForeign(['ledgers_id']);
            $table->dropColumn(['ledgers_id']);
        });
        Schema::dropIfExists('ledgers');
    }
}
