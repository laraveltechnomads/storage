<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RenameReferralNameInSurrogateAgencyMastersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('surrogate_agency_masters', function (Blueprint $table) {
            $table->renameColumn('referral_name', 'referral_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('surrogate_agency_masters', function (Blueprint $table) {
            $table->renameColumn('referral_id', 'referral_name');
        });
    }
}
