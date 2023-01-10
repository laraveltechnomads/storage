<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class EditFromStoreIdAndToStoreIdToIssueManagementTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('issue_management', function (Blueprint $table) {
            $table->dropForeign(['from_store_id']);
            $table->dropForeign(['to_store_id']);
            $table->foreign('from_store_id')->references('id')->on('stores');
            $table->foreign('to_store_id')->references('id')->on('stores');
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
            $table->dropForeign(['from_store_id']);
            $table->dropForeign(['to_store_id']);
            $table->foreign('from_store_id')->references('id')->on('items');
            $table->foreign('to_store_id')->references('id')->on('items');
        });
    }
}
