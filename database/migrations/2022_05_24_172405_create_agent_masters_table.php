<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateAgentMastersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('agent_masters', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('unit_id')->nullable();
            $table->string('name', 100)->nullable();
            $table->date('date_of_birth')->nullable();
            $table->integer('occupation_id')->nullable();
            $table->enum('is_married', ['0', '1'])->default(0)->comment('0=No,1=NO');
            $table->integer('years_of_merrage')->nullable();
            $table->string('spouse_name', 100)->nullable();
            $table->date('spouse_date_of_birth')->nullable();
            $table->enum('previouly_egg_donation', ['0', '1'])->default(0)->comment('0=No,1=NO');
            $table->integer('no_of_donation_time')->nullable();
            $table->text('donation_detail')->nullable();
            $table->enum('previous_surogacy_done', ['0', '1'])->default(0)->comment('0=No,1=NO');
            $table->integer('no_of_surogacy_done')->nullable();
            $table->text('surogacy_detail')->nullable();
            $table->string('mob_country_code', 10)->nullable();
            $table->integer('mobile_no')->nullable();
            $table->string('alt_mob_country_code', 10)->nullable();
            $table->integer('alt_mobile_no')->nullable();
            $table->string('landline_area_code', 10)->nullable();
            $table->integer('landline_no')->nullable();

            $table->string('address_line_1', 100)->nullable();
            $table->string('address_line_2', 100)->nullable();
            $table->string('area', 100)->nullable();
            $table->string('street', 100)->nullable();
            $table->string('landmark', 100)->nullable();
            $table->integer('country_id')->nullable();
            $table->integer('state_id')->nullable();
            $table->integer('city_id')->nullable();
            $table->integer('pincode')->nullable();

            $table->string('pan_no', 12)->nullable();
            $table->integer('aadhar_no')->nullable();

            $table->tinyInteger('status')->default(1)->comment('1:Active, 0:InActive');
            $table->unsignedBigInteger('created_unit_id')->nullable();
            $table->unsignedBigInteger('updated_unit_id')->nullable();
            $table->integer('added_by')->nullable();
            $table->string('added_on', 100)->nullable();
            $table->timestamp('added_date_time')->nullable();
            $table->string('updated_by', 100)->nullable();
            $table->string('updated_on', 100)->nullable();
            $table->timestamp('updated_date_time')->nullable();
            $table->string('added_windows_login_name', 100)->nullable();
            $table->string('update_windows_login_name', 100)->nullable();
            $table->integer('synchronized')->nullable();

            $table->foreign('unit_id')->references('id')->on('units');
            $table->foreign('created_unit_id')->references('id')->on('units');
            $table->foreign('updated_unit_id')->references('id')->on('units');

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
        Schema::dropIfExists('agent_masters');
    }
}
