<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRegIdToAppointmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('appointments', function (Blueprint $table) {
            $table->unsignedBigInteger('reg_id')->nullable()->after('app_unit_id');
            $table->foreign('reg_id')->references('id')->on('registrations');
            $table->unsignedBigInteger('app_type_id')->default(0)->comment("1=Turned Up, 2=Non Turned Up")->nullable()->change();
            $table->foreign('app_type_id')->references('id')->on('appointment_types');
            $table->foreign('app_reason_id')->references('id')->on('appointment_reasons');
            $table->foreign('app_status_id')->references('id')->on('appointment_statuses');
            $table->foreign('doc_id')->references('id')->on('doctors');
            $table->foreign('dept_id')->references('id')->on('departments');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('appointments', function (Blueprint $table) {
            $table->dropForeign(['reg_id']);
            $table->dropColumn('reg_id');
            $table->unsignedBigInteger('app_type_id')->nullable()->change();
            $table->dropForeign(['app_type_id']);
            $table->dropForeign(['app_reason_id']);
            $table->dropForeign(['app_status_id']);
            $table->dropForeign(['doc_id']);
            $table->dropForeign(['dept_id']);
        });
    }
}
