<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateUnitsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('units', function (Blueprint $table) {
            $table->id();
            $table->text('dept_id')->nullable();
            $table->text('store_id')->nullable();
            $table->tinyInteger('status')->default(1)->comment('1= active, 0=inactive');
            $table->tinyInteger('c_id')->nullable();
            $table->string('code', 50)->nullable();
            $table->longText('description')->nullable();
            $table->integer('cluster_id' )->length(6)->unsigned()->nullable();
            $table->string('server_name')->nullable();
            $table->string('clinic_name')->nullable();
            $table->string('database_name')->nullable();
            $table->string('sub_domain')->nullable();
            $table->string('pharmacy_license_no')->nullable();
            $table->string('tin_no')->nullable();
            $table->string('clinic_reg_no')->nullable();
            $table->string('trade_no')->nullable();
            $table->smallInteger('country_id')->nullable();
            $table->smallInteger('state_id')->nullable();
            $table->smallInteger('city_id')->nullable();
            $table->text('address_line1')->nullable();
            $table->text('address_line2')->nullable();
            $table->text('address_line3')->nullable();
            $table->mediumInteger('pincode')->nullable();
            $table->string('contact_no')->nullable();
            $table->string('contact_no1')->nullable();
            $table->smallInteger('mobile_country_code')->nullable();
            $table->string('mobile_no')->nullable();
            $table->string('resi_no_country_code')->nullable();
            $table->string('resi_std_code')->nullable();
            $table->string('fax_no')->nullable();
            $table->string('email')->nullable();
            $table->string('password')->nullable();            
            $table->tinyInteger('is_processing_unit')->default(1)->comment('1= yes, 0=no');
            $table->tinyInteger('is_collection_unit')->default(1)->comment('1= yes, 0=no');
            $table->tinyInteger('synchronized')->default(1)->comment('1= yes, 0=no');
            $table->text('logo')->nullable();
            $table->string('website')->nullable(); 
            $table->tinyInteger('is_date_validation')->default(1)->comment('1= yes, 0=no');
            $table->tinyInteger('is_unit_with_print')->default(1)->comment('1= yes, 0=no');
            $table->string('term')->nullable()->comment('0:Not Accept,1:Accept');
            $table->string('dis_img')->nullable();
            $table->string('gstn_no')->nullable();
            $table->string('area')->nullable();
            $table->string('cin_no')->nullable();
            $table->string('pan_no')->nullable();
            $table->string('reason_for_ad')->nullable();
            $table->string('insta_center_id')->nullable();
            $table->text('permission')->nullable();
            $table->unsignedBigInteger('created_unit_id')->nullable();
            $table->unsignedBigInteger('updated_unit_id')->nullable();
            $table->string('added_by')->nullable();
            $table->string('added_on')->nullable();
            $table->string('added_date_time')->nullable();
            $table->string('added_utc_date_time')->nullable();
            $table->string('added_windows_login_name')->nullable();
            $table->string('updated_by')->nullable();
            $table->string('updated_on')->nullable();
            $table->timestamp('updated_date_time')->nullable();
            $table->timestamp('updated_utc_date_time')->nullable();
            $table->string('updated_windows_login_name')->nullable();
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
        Schema::dropIfExists('units');
    }
}
