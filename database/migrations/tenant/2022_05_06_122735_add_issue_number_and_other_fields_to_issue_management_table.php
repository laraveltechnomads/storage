<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddIssueNumberAndOtherFieldsToIssueManagementTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('issue_management', function (Blueprint $table) {
            $table->string('issue_no')->unique()->collation('utf8_general_ci')->nullable()->after('id');
            $table->string('item_ids')->collation('utf8_general_ci')->nullable()->after('unit_id');
            $table->unsignedBigInteger('patient_id')->nullable()->after('item_ids');
            $table->foreign('patient_id')->references('id')->on('registrations');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('issue_management', function (Blueprint $table) {
            $table->dropColumn(['issue_no']);
            $table->dropColumn(['item_ids']);
            $table->dropForeign(['patient_id']);
            $table->dropColumn(['patient_id']);
        });
    }
}
