<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class EditCodeToCountriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('countries', function (Blueprint $table) {
            $table->string('country_name', 255)->unique()->change();
            if (!Schema::hasColumn('countries', 'nationality')){
                $table->string('nationality')->nullable();
            }
            $table->timestamp('created_at')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->timestamp('updated_at')->nullable()->default(DB::raw('CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP'));
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('countries', function (Blueprint $table) {;
            $table->dropUnique('countries_country_name_unique');
            // $table->string('country_name')->nullable()->unique(false)->change();
            if (Schema::hasColumn('countries', 'nationality')){
                $table->dropColumn('nationality');
            }
            if (Schema::hasColumn('countries', 'created_at')){
                $table->dropColumn('created_at');
            }
            if (Schema::hasColumn('countries', 'updated_at')){
                $table->dropColumn('updated_at');
            }
        });
    }
}
