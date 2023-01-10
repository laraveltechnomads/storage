<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateAppointmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('appointments', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('app_slot_id')->nullable();
            $table->string('registration_type', 50);
            $table->unsignedBigInteger('reg_type_patient_id')->nullable();
            $table->unsignedBigInteger('app_unit_id')->nullable();
            $table->unsignedBigInteger('registration_number')->nullable();
            $table->unsignedBigInteger('reg_unit_id')->nullable();
            $table->unsignedBigInteger('ref_reg_id')->nullable();
            $table->unsignedBigInteger('ref_reg_type')->nullable();
            $table->unsignedBigInteger('visit_id')->nullable();
            $table->unsignedBigInteger('visit_unit_id')->nullable();
            $table->string('first_name')->nullable();
            $table->string('middle_name')->nullable();
            $table->string('last_name')->nullable();
            $table->unsignedBigInteger('gender_id')->nullable();
            $table->date('date_of_birth')->nullable();
            $table->string('marital_status', 20)->nullable();
            $table->string('mobile_country', 50)->nullable();
            $table->string('contact_no', 50)->nullable();
            $table->string('alt_mobile_country', 50)->nullable();
            $table->string('alt_mobile_number', 50)->nullable();
            $table->string('resi_no_country_code', 50)->nullable();
            $table->string('resi_std_code', 50)->nullable();
            $table->string('lanline_number', 50)->nullable();
            $table->string('email_address')->nullable();
            $table->unsignedBigInteger('dept_id')->nullable();
            $table->unsignedBigInteger('doc_id')->nullable();
            $table->unsignedBigInteger('app_reason_id')->nullable();
            $table->string('referred_by')->nullable();
            $table->date('appointment_date')->nullable();
            $table->unsignedBigInteger('time_slot_id')->nullable();
            $table->date('from_date')->nullable();
            $table->date('to_date')->nullable();
            $table->string('remark')->nullable();
            $table->unsignedBigInteger('app_type_id')->nullable();
            $table->boolean('is_acknowledge')->default(0);
            $table->integer('reminder_count')->nullable();
            $table->string('user_name')->nullable();
            $table->boolean('is_cancel')->default(0);
            $table->longText('app_cancel_reason')->nullable();
            $table->string('visit_mark')->nullable();
            $table->boolean('is_sendmail')->default(0);
            $table->boolean('is_send_cancel_mail')->default(0);
            $table->unsignedBigInteger('s_reg_id')->nullable();
            $table->unsignedBigInteger('app_status_id')->default(0)->nullable();
            $table->unsignedBigInteger('parent_appoint_id')->nullable();
            $table->unsignedBigInteger('parent_appoint_unit_id')->nullable();
            $table->boolean('is_reschedule')->default(0);
            $table->unsignedBigInteger('re_shedule_against_app_id')->nullable();
            $table->longText('re_schedulling_reason')->nullable();
            $table->tinyInteger('status')->default(1)->comment('1= active, 0=inactive');
            $table->string('added_by')->nullable();
            $table->string('added_on')->nullable();
            $table->string('added_date_time')->nullable();
            $table->string('updated_by')->nullable();
            $table->string('updated_on')->nullable();
            $table->string('updated_date_time')->nullable();
            $table->string('added_windows_login_name')->nullable();
            $table->string('updated_windows_login_name')->nullable();
            $table->string('patientUnitId')->nullable();
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
        Schema::dropIfExists('appointments');
    }
}