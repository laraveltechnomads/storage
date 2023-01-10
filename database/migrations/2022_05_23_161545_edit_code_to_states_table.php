<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class EditCodeToStatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('states', function (Blueprint $table) {
            $table->string('state_code')->change();
            $table->string('state_name', 255)->unique()->change();
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
        Schema::table('states', function (Blueprint $table) {
            $table->smallInteger('state_code')->change();
            $table->dropUnique('states_state_name_unique');
                       
            if (Schema::hasColumn('states', 'created_at')){
                $table->dropColumn('created_at');
            }
            if (Schema::hasColumn('states', 'updated_at')){
                $table->dropColumn('updated_at');
            }
        });
        
    }
}
