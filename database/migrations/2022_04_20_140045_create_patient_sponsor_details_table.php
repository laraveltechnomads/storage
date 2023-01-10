<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePatientSponsorDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('patient_sponsor_details', function (Blueprint $table) {
            $table->id();
            $table->string('patient_id',100)->nullable();
            $table->string('patient_unit_id',100)->nullable();
            $table->string('patient_source_id',100)->nullable();
            $table->string('company_id',100)->nullable();
            $table->string('associated_company_id',100)->nullable();
            $table->string('reference_no',100)->nullable();
            $table->string('credit_limit',100)->nullable();
            $table->string('effective_date',100)->nullable();
            $table->string('expiry_date',100)->nullable();
            $table->string('tariff_id',100)->nullable();
            $table->string('employee_no',100)->nullable();
            $table->string('designation_id',100)->nullable();
            $table->string('remark',100)->nullable();
            $table->string('status',100)->comment('1:Active,0:Inactive')->nullable();
            $table->string('created_unit_id',100)->nullable();
            $table->string('updated_unit_id',100)->nullable();
            $table->string('added_by',100)->nullable();
            $table->string('added_on',100)->nullable();
            $table->string('added_date_time',100)->nullable();
            $table->string('updated_by',100)->nullable();
            $table->string('updated_on',100)->nullable();
            $table->string('updated_date_time',100)->nullable();
            $table->string('added_windows_login_name',100)->nullable();
            $table->string('updated_windows_login_name',100)->nullable();
            $table->string('synchronized',100)->nullable();
            $table->string('membership_card_issue_date',100)->nullable();
            $table->string('prefer_name_on_card',100)->nullable();
            $table->string('is_family',100)->nullable();
            $table->string('parent_patient_id',100)->nullable();
            $table->string('parent_patient_unit_id',100)->nullable();
            $table->string('parent_sponsor_id',100)->nullable();
            $table->string('parent_sponsor_unit_id',100)->nullable();
            $table->string('poc_doctor_id',100)->nullable();
            $table->string('member_relation_id',100)->nullable();
            $table->string('patient_category_id',100)->nullable();
            $table->string('pat_sponsor_id',100)->nullable();
            $table->string('sponsor_unit_id',100)->nullable();
            $table->string('visit_id',100)->nullable();
            $table->string('visit_unit_id',100)->nullable();
            $table->string('cat_l2_id',100)->nullable();
            $table->string('comp_ass_id',100)->nullable();
            $table->string('tid',100)->nullable();
            $table->string('staff_relation_id',100)->nullable();
            $table->string('v_from_date',100)->nullable();
            $table->string('v_to_date',100)->nullable();
            $table->string('is_staff_discount',100)->nullable();
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
        Schema::dropIfExists('patient_sponsor_details');
    }
}
