<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateClientCredentialCronsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('client_credential_crons', function (Blueprint $table) {
            $table->id();
            $table->string('client_fname', 50)->nullable();
            $table->string('client_lname', 50)->nullable();
            $table->string('email_address', 90)->unique()->nullable();
            $table->string('sub_domain')->unique()->nullable();
            $table->string('db_name')->unique()->nullable();
            $table->tinyInteger('status')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('client_credential_crons');
    }
}
