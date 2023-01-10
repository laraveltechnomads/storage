<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateVisitsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('visits', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('unit_id')->nullable();
            $table->dateTime('date_time', $precision = 0)->nullable();
            $table->unsignedBigInteger('spouse_id')->default(1)->nullable();
            $table->unsignedBigInteger('patient_id')->nullable();
            $table->unsignedBigInteger('patient_unit_id')->nullable();
            $table->unsignedBigInteger('OPD_no')->nullable();
            $table->unsignedInteger('visit_type_id')->nullable();
            $table->string('complaints')->nullable();
            $table->unsignedBigInteger('department_id')->nullable();
            $table->unsignedBigInteger('doctor_id')->nullable();
            $table->unsignedInteger('cabin_id')->nullable();
            $table->unsignedBigInteger('referred_doctor_id')->nullable();
            $table->longText('visit_notes')->nullable();
            $table->text('referred_doctor')->nullable();
            $table->integer('visit_status')->comment('0:Inactive,1:Active')->nullable();
            $table->integer('current_visit_status')->comment('0:Inactive,1:Active')->nullable();
            $table->unsignedInteger('visit_type_service_id')->nullable();
            $table->text('patient_case_record')->nullable();
            $table->text('case_referral_sheet')->nullable();
            $table->string('token_no')->nullable();
            $table->time('time')->nullable();
            $table->unsignedBigInteger('created_unit_id')->nullable();
            $table->unsignedBigInteger('updated_unit_id')->nullable();
            $table->string('added_by')->nullable();
            $table->string('added_on')->nullable();
            $table->string('added_date_time')->nullable();
            $table->string('added_utc_date_time')->nullable();
            $table->string('added_windows_login_name')->nullable();
            $table->string('updated_by')->nullable();
            $table->string('updated_on')->nullable();
            $table->string('updated_date_time')->nullable();
            $table->timestamp('updated_utc_date_time')->nullable();            
            $table->string('updated_windows_login_name')->nullable();
            $table->tinyInteger('synchronized')->default(1)->comment('1= active, 0=inactive');
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
        Schema::dropIfExists('visits');
    }
}
