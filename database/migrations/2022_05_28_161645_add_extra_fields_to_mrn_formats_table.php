<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class AddExtraFieldsToMrnFormatsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('mrn_formats', function (Blueprint $table) {
            $table->tinyInteger('status')->default(1)->comment('1=active, 0=inactive')->after('unit_id');
            $table->string('sequence_name')->unique()->collation('utf8_general_ci')->nullable()->after('unit_id');
            $table->integer('sequence')->unique()->nullable()->after('unit_id');
            $table->string('result')->collation('utf8_general_ci')->nullable()->after('unit_id');
            $table->string('dept_code')->collation('utf8_general_ci')->nullable()->after('unit_id');
            $table->string('reg_type')->collation('utf8_general_ci')->nullable()->after('unit_id');
            $table->string('trans_type')->collation('utf8_general_ci')->nullable()->after('unit_id');
            $table->integer('index_no')->length(6)->nullable()->after('unit_id');
            $table->string('year')->collation('utf8_general_ci')->nullable()->after('unit_id');
            $table->string('month')->collation('utf8_general_ci')->nullable()->after('unit_id');
            $table->string('city_code')->collation('utf8_general_ci')->nullable()->after('unit_id');
            $table->string('unit_code')->collation('utf8_general_ci')->nullable()->after('unit_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('mrn_formats', function (Blueprint $table) {
            $table->dropColumn('unit_code', 'city_code', 'month', 'year', 'index_no', 'trans_type', 'reg_type', 'dept_code', 'result', 'sequence', 'status', 'sequence_name');
        });
    }
}
