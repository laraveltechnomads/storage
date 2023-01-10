<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateCompanyAssociateMastersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('company_associate_masters', function (Blueprint $table) {
            $table->id();
            $table->string('comp_ass_code',16)->nullable();
            $table->string('description')->nullable();
            $table->unsignedBigInteger('comp_id')->nullable();
            $table->foreign('comp_id')->references('id')->on('company_masters')->onDelete('cascade');
            $table->string('fcontact_person',16)->nullable();
            $table->string('faddress_line1')->nullable();
            $table->string('faddress_line2')->nullable();
            $table->string('femail',100)->nullable();
            $table->string('fstreet',16)->nullable();
            $table->string('flandmark',16)->nullable();
            $table->string('fmobile_country_id',16)->nullable();
            $table->string('fmobile_no',16)->nullable();
            $table->string('falt_mobile_country_id',16)->nullable();
            $table->string('falt_mobileno',16)->nullable();
            $table->string('fresi_std_code',16)->nullable();
            $table->string('fresi_landlineno',16)->nullable();
            $table->string('falt_resi_std_code',16)->nullable();
            $table->string('falt_resi_landlineno',16)->nullable();
            $table->string('fcountry_id',16)->nullable();
            $table->string('fstate_id',16)->nullable();
            $table->string('fcity_id',16)->nullable();
            $table->string('farea',16)->nullable();
            $table->string('fpincode',16)->nullable();
            $table->string('scontact_person',16)->nullable();
            $table->string('saddress_line1')->nullable();
            $table->string('saddress_line2')->nullable();
            $table->string('semail',100)->nullable();
            $table->string('sstreet',16)->nullable();
            $table->string('slandmark',16)->nullable();
            $table->string('smobile_country_id',16)->nullable();
            $table->string('smobile_no',16)->nullable();
            $table->string('salt_mobile_country_id',16)->nullable();
            $table->string('salt_mobileno',16)->nullable();
            $table->string('sresi_std_code',16)->nullable();
            $table->string('sresi_landlineno',16)->nullable();
            $table->string('salt_resi_std_code',16)->nullable();
            $table->string('salt_resi_landlineno',16)->nullable();
            $table->string('scountry_id',16)->nullable();
            $table->string('sstate_id',16)->nullable();
            $table->string('scity_id',16)->nullable();
            $table->string('sarea',16)->nullable();
            $table->string('spincode',16)->nullable();
            $table->integer('status')->comment('1:Active,0:Inactive')->nullable();
            $table->string('created_unit_id',16)->nullable();
            $table->string('updated_unit_id',16)->nullable();
            $table->string('added_by',16)->nullable();
            $table->string('added_on',16)->nullable();
            $table->string('added_date_time',16)->nullable();
            $table->string('updated_by',16)->nullable();
            $table->string('updated_on',16)->nullable();
            $table->string('updated_date_time',16)->nullable();
            $table->string('added_windows_login_name',16)->nullable();
            $table->string('update_windows_login_name',16)->nullable();
            $table->string('synchronized',16)->nullable();
            $table->timestamp('created_at')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->timestamp('updated_at')->nullable()->default(DB::raw('CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP'));
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('company_associate_masters');
    }
}
