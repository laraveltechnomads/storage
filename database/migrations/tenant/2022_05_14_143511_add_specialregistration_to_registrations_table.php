<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddSpecialregistrationToRegistrationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('registrations', function (Blueprint $table) {
            $table->unsignedBigInteger('is_special_reg')->nullable()->after('patientUnitId');            
            $table->foreign('is_special_reg')->references('id')->on('special_registrations')->onDelete('cascade');
            $table->unsignedBigInteger('is_donor')->nullable()->after('is_special_reg');            
            $table->foreign('is_donor')->references('id')->on('donor_registrations')->onDelete('cascade');
            $table->string('reg_from')->nullable()->after('is_donor');
        });
    }
    

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('registrations', function (Blueprint $table) {
            $table->dropForeign(['is_special_reg']);
            $table->dropColumn(['is_special_reg']);
            $table->dropForeign(['is_donor']);
            $table->dropColumn(['is_donor']);
            $table->dropColumn(['reg_from']);
        });
    }
}
