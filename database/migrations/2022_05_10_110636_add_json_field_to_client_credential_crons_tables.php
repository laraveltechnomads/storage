<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddJsonFieldToClientCredentialCronsTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('client_credential_crons', function (Blueprint $table) {
            $table->string('client_json', 255)->after('db_name')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('client_credential_crons', function (Blueprint $table) {
            $table->dropColumn(['client_json']);
        });
    }
}
