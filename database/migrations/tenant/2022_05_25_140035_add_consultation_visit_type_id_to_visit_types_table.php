<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddConsultationVisitTypeIdToVisitTypesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('visit_types', function (Blueprint $table) {
            $table->renameColumn('Is_clinical', 'is_clinical');
            $table->tinyInteger('is_free')->default(0)->comment('1= active, 0=inactive')->after('synchronized');
            $table->integer('free_days')->default(0)->after('synchronized');
            $table->unsignedBigInteger('consultation_visit_type_id')->nullable()->after('synchronized');
            $table->foreign('consultation_visit_type_id')->references('id')->on('consultation_visit_types');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('visit_types', function (Blueprint $table) {
            $table->renameColumn('is_clinical', 'Is_clinical');
            $table->dropColumn(['is_free']);
            $table->dropColumn(['free_days']);
            $table->dropForeign(['consultation_visit_type_id']);
            $table->dropColumn(['consultation_visit_type_id']);
        });
    }
}
