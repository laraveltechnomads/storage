<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddBabyIdToRegistrationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('registrations', function (Blueprint $table) {
            $table->string('email_address', 90)->nullable()->change();
            $table->unsignedBigInteger('baby_id')->nullable()->after('mrn_number');         
            $table->foreign('baby_id')->references('id')->on('baby_registrations')->onDelete('cascade');
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
            $table->dropForeign(['baby_id']);
            $table->dropColumn(['baby_id']);
            $table->string('email_address', 90)->change();
        });
    }
}
