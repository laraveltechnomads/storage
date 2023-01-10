<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddStoredepartToUnitsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('units', function (Blueprint $table) {
            if (!Schema::hasColumn('units', 'department'))
            {
                $table->text('department')->nullable()->after('permission');
            }
            if (!Schema::hasColumn('units', 'store'))
            {
                $table->text('store')->nullable()->after('department');
            }
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('units', function (Blueprint $table) {
            if (Schema::hasColumn('units', 'department')) 
            {
                $table->dropColumn(['department']);
            }
            if (Schema::hasColumn('units', 'store')) 
            {
                $table->dropColumn(['store']);
            }
        });
    }
}
