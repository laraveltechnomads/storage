<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RenameSRegCodeInSpecialRegistrationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('special_registrations', function (Blueprint $table) {
            $table->renameColumn('s_reg_code', 'code');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('special_registrations', function (Blueprint $table) {
            $table->renameColumn('code', 's_reg_code');
        });
    }
}
