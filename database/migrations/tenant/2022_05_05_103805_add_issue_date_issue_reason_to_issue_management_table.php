<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddIssueDateIssueReasonToIssueManagementTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('issue_management', function (Blueprint $table) {
            $table->dropColumn(['appointment_date']);
            $table->float('amount', 8, 2)->default(0)->nullable()->change();
            $table->date('issue_date')->nullable()->after('amount');
            $table->text('issue_reason')->nullable()->collation('utf8_general_ci')->after('to_store_id');
            $table->text('remark')->nullable()->collation('utf8_general_ci')->after('issue_reason');
            $table->foreign('item_id')->references('id')->on('items');
            $table->foreign('from_store_id')->references('id')->on('items');
            $table->foreign('to_store_id')->references('id')->on('items');
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
            $table->string('appointment_date',100)->nullable();
            $table->float('amount', 8, 2);
            $table->dropColumn(['issue_reason']);
            $table->dropColumn(['issue_date']);
            $table->dropColumn(['remark']);
            $table->dropForeign('item_id');
            $table->dropForeign('from_store_id');
            $table->dropForeign('to_store_id');
        });
    }
}
