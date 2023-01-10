<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Query\Expression;
use Illuminate\Support\Facades\DB;

class AddFieldToMoleculesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('molecules', function (Blueprint $table) {
            $table->foreign('unit_id')->references('id')->on('units');
        });
        Schema::table('item_enquiries', function (Blueprint $table) {
            $table->string('enquiry_no')->after('item_ids')->nullable();
        });
        Schema::table('client_credential_crons', function (Blueprint $table) {
            $table->bigInteger('client_id')->after('id')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('molecules', function (Blueprint $table) {
            $table->dropForeign(['unit_id']);
        });
        Schema::table('item_enquiries', function (Blueprint $table) {
            $table->dropColumn(['enquiry_no']);
        });
        Schema::table('client_credential_crons', function (Blueprint $table) {
            $table->dropColumn(['client_id']);
        });
    }
}
