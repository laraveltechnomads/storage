<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddUnitIdAndUserIdToDoctorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasColumn('doctors', 'patientUnitId')){
                Schema::table('doctors', function (Blueprint $table) {
                    $table->dropColumn(['patientUnitId']);
                    $table->unsignedBigInteger('unit_id')->after('doc_type_id');
                    $table->unsignedBigInteger('user_id')->after('doc_type_id');
                    $table->foreign('unit_id')->references('id')->on('units');
            });
        }
        Schema::table('appointments', function (Blueprint $table) {
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        if (Schema::hasColumn('doctors', 'patientUnitId')){
            Schema::table('doctors', function (Blueprint $table) {
                $table->string('patientUnitId')->nullable();
                $table->dropColumn(['unit_id']);
                $table->dropColumn(['user_id']);
                $table->dropForeign(['unit_id']);
            });
        }
    }
}
