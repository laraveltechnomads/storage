<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class EditUserIdAndUnitToDoctorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('doctors', function (Blueprint $table) {
            $table->unsignedBigInteger('user_id')->nullable()->change();
            $table->unsignedBigInteger('unit_id')->nullable()->change();
            $table->string('photo', 255)->nullable()->after('updated_windows_login_name');
            $table->string('documents', 255)->nullable()->after('photo');
            $table->unsignedBigInteger('marital_status')->nullable()->after('documents');
            $table->string('pf_no')->nullable()->after('marital_status');
            $table->string('email_address', 90)->unique()->nullable()->after('pf_no');
            $table->integer('access_card_no')->nullable()->after('email_address');
            $table->string('departments')->nullable()->after('access_card_no');
            $table->string('classifications')->nullable()->after('departments');
            $table->foreign('gender_id')->references('id')->on('genders');
            $table->foreign('marital_status')->references('id')->on('marital_statuses');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('doctors', function (Blueprint $table) {
            $table->unsignedBigInteger('unit_id')->change();
            $table->unsignedBigInteger('user_id')->change();
            $table->dropForeign(['marital_status']);
            $table->dropForeign(['gender_id']);
            $table->dropColumn(['photo', 'documents', 'marital_status', 'pf_no', 'email_address', 'access_card_no', 'departments', 'classifications']);
        });
    }
}
