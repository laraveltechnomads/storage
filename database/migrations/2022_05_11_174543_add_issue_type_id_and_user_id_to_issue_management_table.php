<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddIssueTypeIdAndUserIdToIssueManagementTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('issue_management', function (Blueprint $table) {
            $table->unsignedBigInteger('issue__type_id')->nullable()->after('issue_no');
            $table->unsignedBigInteger('user_id')->nullable()->after('issue__type_id');
            $table->foreign('issue__type_id')->references('id')->on('issue_types');
            $table->foreign('user_id')->references('id')->on('users');
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
            $table->dropForeign(['issue__type_id']);
            $table->dropForeign(['user_id']);
            $table->dropColumn(['issue__type_id']);
            $table->dropColumn(['user_id']);
        });
    }
}