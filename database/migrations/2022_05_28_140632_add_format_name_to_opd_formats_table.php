<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFormatNameToOpdFormatsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('opd_formats', function (Blueprint $table) {
            $table->integer('sequence')->unique()->change();
            $table->string('sequence_name')->unique()->collation('utf8_general_ci')->nullable()->after('sequence');
        });
        Schema::table('ipd_formats', function (Blueprint $table) {
            $table->integer('sequence')->unique()->change();
            $table->string('sequence_name')->unique()->collation('utf8_general_ci')->nullable()->after('sequence');
        });
        Schema::table('receipt_formats', function (Blueprint $table) {
            $table->integer('sequence')->unique()->change();
            $table->string('sequence_name')->unique()->collation('utf8_general_ci')->nullable()->after('sequence');
        });
        Schema::table('inventory_formats', function (Blueprint $table) {
            $table->integer('sequence')->unique()->change();
            $table->string('sequence_name')->unique()->collation('utf8_general_ci')->nullable()->after('sequence');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('opd_formats', function (Blueprint $table) {
            $table->dropUnique(['sequence']);
            $table->dropColumn('sequence_name');
        });
        Schema::table('ipd_formats', function (Blueprint $table) {
            $table->dropUnique(['sequence']);
            $table->dropColumn('sequence_name');
        });
        Schema::table('receipt_formats', function (Blueprint $table) {
            $table->dropUnique(['sequence']);
            $table->dropColumn('sequence_name');
        });
        Schema::table('inventory_formats', function (Blueprint $table) {
            $table->dropUnique(['sequence']);
            $table->dropColumn('sequence_name');
        });
    }
}
