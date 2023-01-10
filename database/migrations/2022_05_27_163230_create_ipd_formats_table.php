<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateIpdFormatsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ipd_formats', function (Blueprint $table) {
            $table->id();
            $table->string('unit_code')->collation('utf8_general_ci')->nullable();
            $table->string('city_code')->collation('utf8_general_ci')->nullable();
            $table->string('month')->collation('utf8_general_ci')->nullable();
            $table->string('year')->collation('utf8_general_ci')->nullable();
            $table->integer('index_no')->length(6)->nullable();
            $table->string('trans_type')->collation('utf8_general_ci')->nullable();
            $table->string('reg_type')->collation('utf8_general_ci')->nullable();
            $table->string('dept_code')->collation('utf8_general_ci')->nullable();
            $table->string('result')->collation('utf8_general_ci')->nullable();
            $table->integer('sequence')->nullable();
            $table->tinyInteger('status')->default(1)->comment('1=active, 0=inactive');
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
        Schema::dropIfExists('ipd_formats');
    }
}
