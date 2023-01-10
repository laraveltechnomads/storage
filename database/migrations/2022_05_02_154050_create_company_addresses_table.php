<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCompanyAddressesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('company_addresses', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('comp_id')->nullable();
            $table->foreign('comp_id')->references('id')->on('company_masters')->onDelete('cascade');   
            $table->string('comp_unit_id',16)->nullable();
            $table->string('contact_person',16)->nullable();
            $table->string('address_line1',100)->nullable();
            $table->string('address_line2',100)->nullable();
            $table->string('email',16)->nullable();
            $table->string('street',16)->nullable();
            $table->string('landmark',16)->nullable();
            $table->string('mobile_country_id',16)->nullable();
            $table->string('mobile_no',16)->nullable();
            $table->string('alt_mobile_country_id',16)->nullable();
            $table->string('alt_mobileno',16)->nullable();
            $table->string('resi_std_code',16)->nullable();
            $table->string('resi_landlineno',16)->nullable();
            $table->string('altresi_std_code',16)->nullable();
            $table->string('altresi_landlineno',16)->nullable();
            $table->string('country_id',16)->nullable();
            $table->string('state_id',16)->nullable();
            $table->string('city_id',16)->nullable();
            $table->string('area',16)->nullable();
            $table->string('pincode',16)->nullable();
            $table->string('is_default',16)->nullable();
            $table->string('status',16)->nullable();
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
        Schema::dropIfExists('company_addresses');
    }
}
