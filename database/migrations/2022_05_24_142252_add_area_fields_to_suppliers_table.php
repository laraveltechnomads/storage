<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddAreaFieldsToSuppliersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('suppliers', function (Blueprint $table) {
            $table->string('area',100)->nullable()->after('synchronized');
            $table->string('po_auto_close',100)->nullable()->after('area');
            $table->string('gstin_number',100)->nullable()->after('po_auto_close');
            if (Schema::hasColumn('suppliers', 'country_code')){
                Schema::table('suppliers', function (Blueprint $table) {
                    $table->dropColumn(['country_code']);
                });
            }
            if (Schema::hasColumn('suppliers', 'state_code')){
                Schema::table('suppliers', function (Blueprint $table) {
                    $table->dropColumn(['state_code']);
                });
            }
            if (Schema::hasColumn('suppliers', 'city_code')){
                Schema::table('suppliers', function (Blueprint $table) {
                    $table->dropColumn(['city_code']);
                });
            }
            $table->unsignedBigInteger('country_code')->nullable();
            $table->unsignedBigInteger('state_code')->nullable();
            $table->unsignedBigInteger('city_code')->nullable();
            $table->foreign('country_code')->references('id')->on('countries');
            $table->foreign('state_code')->references('id')->on('states');
            $table->foreign('city_code')->references('id')->on('cities');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('suppliers', function (Blueprint $table) {
            $table->dropForeign(['country_code']);
            $table->dropColumn(['country_code']);
            $table->dropForeign(['state_code']);
            $table->dropColumn(['state_code']);
            $table->dropForeign(['city_code']);
            $table->dropColumn(['city_code']);
            $table->dropColumn(['area']);
            $table->dropColumn(['po_auto_close']);
            $table->dropColumn(['gstin_number']);
        });
    }
}
