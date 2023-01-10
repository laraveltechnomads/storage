<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddStoreCodeToInventoryFormatsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('inventory_formats', function (Blueprint $table) {
            $table->string('supllier_code')->collation('utf8_general_ci')->nullable()->after('dept_code');
            $table->string('to_store_code')->collation('utf8_general_ci')->nullable()->after('dept_code');
            $table->string('from_store_code')->collation('utf8_general_ci')->nullable()->after('dept_code');
            $table->string('store_code')->collation('utf8_general_ci')->nullable()->after('dept_code');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('inventory_formats', function (Blueprint $table) {
            $table->dropColumn('supllier_code', 'to_store_code', 'from_store_code', 'store_code');
        });
    }
}
