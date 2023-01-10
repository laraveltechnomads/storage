<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class EditSequenceToOpdFormatsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('opd_formats', function (Blueprint $table) {
            $table->dropColumn('result');
            $table->text('sequence')->change();
        });
        Schema::table('ipd_formats', function (Blueprint $table) {
            $table->dropColumn('result');
            $table->text('sequence')->change();
        });
        Schema::table('receipt_formats', function (Blueprint $table) {
            $table->dropColumn('result');
            $table->text('sequence')->change();
        });
        Schema::table('inventory_formats', function (Blueprint $table) {
            $table->dropColumn('result');
            $table->text('sequence')->change();
        });
        Schema::table('mrn_formats', function (Blueprint $table) {
            $table->dropColumn('result');
            $table->text('sequence')->change();
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
            $table->string('result')->collation('utf8_general_ci')->nullable()->after('dept_code');
            $table->integer('sequence')->change();
        });
        Schema::table('ipd_formats', function (Blueprint $table) {
            $table->string('result')->collation('utf8_general_ci')->nullable()->after('dept_code');
            $table->integer('sequence')->change();
        });
        Schema::table('receipt_formats', function (Blueprint $table) {
            $table->string('result')->collation('utf8_general_ci')->nullable()->after('dept_code');
            $table->integer('sequence')->change();
        });
        Schema::table('inventory_formats', function (Blueprint $table) {
            $table->string('result')->collation('utf8_general_ci')->nullable()->after('dept_code');
            $table->integer('sequence')->change();
        });
        Schema::table('mrn_formats', function (Blueprint $table) {
            $table->string('result')->collation('utf8_general_ci')->nullable()->after('unit_id');
            $table->integer('sequence')->change();
        });
    }
}
