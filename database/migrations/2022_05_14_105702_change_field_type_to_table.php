<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class ChangeFieldTypeToTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement("SET FOREIGN_KEY_CHECKS = 0;");
        Schema::table('batches', function (Blueprint $table) {
            $table->unsignedBigInteger('created_unit_id')->nullable()->change();
            $table->unsignedBigInteger('updated_unit_id')->nullable()->change();
            $table->foreign('created_unit_id')->references('id')->on('units');
            $table->foreign('updated_unit_id')->references('id')->on('units');
            $table->dateTime('added_date_time')->nullable()->change();
            $table->dateTime('updated_date_time')->nullable()->change();
        });
        Schema::table('items', function (Blueprint $table) {
            $table->unsignedBigInteger('dispensing_id')->nullable()->after('item_category_id');
            $table->foreign('dispensing_id')->references('id')->on('dispensings');
            $table->unsignedBigInteger('storage_type_id')->nullable()->after('dispensing_id');
            $table->foreign('storage_type_id')->references('id')->on('storage_types');
            $table->foreign('created_unit_id')->references('id')->on('units');
            $table->foreign('updated_unit_id')->references('id')->on('units');
            $table->dateTime('added_date_time')->nullable()->change();
            $table->integer('status')->comment('1:Active, 0: InActive')->default(1)->change();
        });
        Schema::table('item_categories', function (Blueprint $table) {
            $table->foreign('created_unit_id')->references('id')->on('units');
            $table->foreign('updated_unit_id')->references('id')->on('units');
            $table->integer('status')->default(1)->comment('1:Active, 0: InActive')->change();
        });
        Schema::table('item_clinics', function (Blueprint $table) {
            $table->integer('status')->default(1)->comment('1:Active, 0:InActive')->change();
            $table->unsignedBigInteger('created_unit_id')->nullable()->change();
            $table->unsignedBigInteger('updated_unit_id')->nullable()->change();
            $table->foreign('created_unit_id')->references('id')->on('units');
            $table->foreign('updated_unit_id')->references('id')->on('units');
            $table->dateTime('added_date_time')->collation('utf8_general_ci')->nullable()->change();
            $table->dateTime('added_utc_date_time')->collation('utf8_general_ci')->nullable()->change();
            $table->dateTime('updated_date_time')->collation('utf8_general_ci')->nullable()->change();
        });
        Schema::table('item_groups', function (Blueprint $table) {
            $table->integer('status')->default(1)->comment('1:Active, 0:InActive')->change();
            $table->foreign('created_unit_id')->references('id')->on('units');
            $table->foreign('updated_unit_id')->references('id')->on('units');
        });
        Schema::table('item_margin_masters', function (Blueprint $table) {
            $table->foreign('created_unit_id')->references('id')->on('units');
            $table->foreign('updated_unit_id')->references('id')->on('units');
            $table->integer('status')->comment('1:Active, 0:InActive')->default(1)->nullable()->change();
            $table->dateTime('added_utc_date_time')->nullable()->change();
            $table->dateTime('updated_utc_date_time')->nullable()->change();
        });
        Schema::table('item_movement_masters', function (Blueprint $table) {
            $table->foreign('created_unit_id')->references('id')->on('units');
            $table->foreign('updated_unit_id')->references('id')->on('units');
            $table->integer('status')->default(1)->comment('1:Active, 0:InActive')->change();
            $table->dateTime('added_utc_date_time')->nullable()->change();
            $table->dateTime('updated_utc_date_time')->nullable()->change();
        });
        Schema::table('advance_against_details', function (Blueprint $table) {
            $table->integer('status')->comment('0:Inactive,1:Active')->default(1)->change();
            $table->unsignedBigInteger('created_unit_id')->nullable()->change();
            $table->unsignedBigInteger('updated_unit_id')->nullable()->change();
            $table->foreign('created_unit_id')->references('id')->on('units');
            $table->foreign('updated_unit_id')->references('id')->on('units');
            $table->dateTime('added_date_time')->nullable()->change();
            $table->renameColumn('Added_utc_date_time','added_utc_date_time');
            $table->dateTime('added_utc_date_time')->nullable()->change();
            $table->dateTime('updated_date_time')->nullable()->change();
            $table->dateTime('updated_utc_date_time')->nullable()->change();
        });
        Schema::table('appointments', function (Blueprint $table) {
            $table->dateTime('added_date_time')->nullable()->change();
            $table->dateTime('updated_date_time')->nullable()->change();
        });
        Schema::table('appointment_reasons', function (Blueprint $table) {
            $table->dateTime('added_date_time')->nullable()->change();
            $table->dateTime('added_utc_date_time')->nullable()->change();
            $table->dateTime('updated_utc_date_time')->nullable()->change();
            $table->foreign('created_unit_id')->references('id')->on('units');
            $table->foreign('updated_unit_id')->references('id')->on('units');
        });
        Schema::table('ass_company_tariff_details', function (Blueprint $table) {
            $table->dateTime('added_date_time')->nullable()->change();
            $table->dateTime('updated_date_time')->nullable()->change();
            $table->unsignedBigInteger('created_unit_id')->nullable()->change();
            $table->unsignedBigInteger('updated_unit_id')->nullable()->change();
            $table->foreign('created_unit_id')->references('id')->on('units');
            $table->foreign('updated_unit_id')->references('id')->on('units');
        });
        Schema::table('baby_registrations', function (Blueprint $table) {
            $table->unsignedSmallInteger('patient_category_id')->nullable()->change();
            $table->foreign('patient_category_id')->references('id')->on('patient_categories');
            $table->dateTime('added_date_time')->nullable()->change();
            $table->dateTime('updated_date_time')->nullable()->change();
        });
        Schema::table('bulk_rate_changes', function (Blueprint $table) {
            $table->integer('status')->comment('0:Inactive,1:Active')->default(1)->change();
            $table->dateTime('added_date_time')->nullable()->change();
            $table->dateTime('added_utc_date_time')->nullable()->change();
            $table->dateTime('updated_date_time')->nullable()->change();
            $table->dateTime('updated_utc_date_time')->nullable()->change();
            $table->unsignedBigInteger('created_unit_id')->nullable()->change();
            $table->unsignedBigInteger('updated_unit_id')->nullable()->change();
            $table->foreign('created_unit_id')->references('id')->on('units');
            $table->foreign('updated_unit_id')->references('id')->on('units');
        });
        Schema::table('bulk_rate_change_specializations', function (Blueprint $table) {
            $table->integer('status')->comment('0:Inactive,1:Active')->default(1)->change();
        });
        Schema::table('bulk_rate_change_tarrifs', function (Blueprint $table) {
            $table->integer('status')->comment('0:Inactive,1:Active')->default(1)->change();
        });
        Schema::table('code_type_masters', function (Blueprint $table) {
            $table->integer('status')->comment('0:Inactive,1:Active')->default(1)->change();
        });
        Schema::table('company_addresses', function (Blueprint $table) {
            $table->integer('status')->comment('0:Inactive,1:Active')->default(1)->change();
            $table->dateTime('added_date_time')->nullable()->change();
            $table->dateTime('updated_date_time')->nullable()->change();
        });
        Schema::table('company_associate_masters', function (Blueprint $table) {
            $table->integer('status')->comment('0:Inactive,1:Active')->default(1)->change();
            $table->dateTime('added_date_time')->nullable()->change();
            $table->dateTime('updated_date_time')->nullable()->change();
        });
        Schema::table('company_masters', function (Blueprint $table) {
            $table->integer('status')->comment('1:Active,0:Inactive')->default(1)->change();
            $table->dateTime('added_date_time')->nullable()->change();
            $table->dateTime('updated_date_time')->nullable()->change();
            $table->dateTime('updated_utc_date_time')->nullable()->change();
        });
        Schema::table('company_type_masters', function (Blueprint $table) {
            $table->integer('status')->comment('1:Active,0:Inactive')->default(1)->change();
            $table->unsignedBigInteger('created_unit_id')->nullable()->change();
            $table->unsignedBigInteger('updated_unit_id')->nullable()->change();
            $table->foreign('created_unit_id')->references('id')->on('units');
            $table->foreign('updated_unit_id')->references('id')->on('units');
            $table->dateTime('added_date_time')->nullable()->change();
            $table->dateTime('added_utc_date_time')->nullable()->change();
            $table->dateTime('updated_date_time')->nullable()->change();
            $table->dateTime('updated_utc_date_time')->nullable()->change();
        });
        Schema::table('con_reason_masters', function (Blueprint $table) {
            $table->integer('status')->comment('1:Active,0:Inactive')->default(1)->change();
            $table->unsignedBigInteger('created_unit_id')->nullable()->change();
            $table->unsignedBigInteger('updated_unit_id')->nullable()->change();
            $table->foreign('created_unit_id')->references('id')->on('units');
            $table->foreign('updated_unit_id')->references('id')->on('units');
            $table->dateTime('added_date_time')->nullable()->change();
            $table->dateTime('added_utc_date_time')->nullable()->change();
            $table->dateTime('updated_date_time')->nullable()->change();
            $table->dateTime('updated_utc_date_time')->nullable()->change();
        });
        Schema::table('couple_links', function (Blueprint $table) {
            $table->integer('status')->comment('1:Active,0:Inactive')->default(1)->change();
            $table->unsignedBigInteger('created_unit_id')->nullable()->change();
            $table->unsignedBigInteger('updated_unit_id')->nullable()->change();
            $table->foreign('created_unit_id')->references('id')->on('units');
            $table->foreign('updated_unit_id')->references('id')->on('units');
            $table->dateTime('added_date_time')->nullable()->change();
            $table->dateTime('added_utc_data_time')->nullable()->change();
            $table->dateTime('updated_date_time')->nullable()->change();
        });
        Schema::table('departments', function (Blueprint $table) {
            $table->foreign('created_unit_id')->references('id')->on('units');
            $table->foreign('updated_unit_id')->references('id')->on('units');
            $table->dateTime('added_date_time')->nullable()->change();
            $table->dateTime('added_utc_date_time')->nullable()->change();
        });
        Schema::table('dispensings', function (Blueprint $table) {
            $table->integer('status')->comment('1:Active,0:Inactive')->default(1)->change();
            $table->foreign('created_unit_id')->references('id')->on('units');
            $table->foreign('updated_unit_id')->references('id')->on('units');
        });
        Schema::table('doctor_categories', function (Blueprint $table) {
            $table->foreign('created_unit_id')->references('id')->on('units');
            $table->foreign('updated_unit_id')->references('id')->on('units');
            $table->dateTime('added_date_time')->nullable()->change();
            $table->dateTime('updated_date_time')->nullable()->change();
        });
        Schema::table('doctor_department_details', function (Blueprint $table) {
            $table->foreign('doc_id')->references('id')->on('doctors');
            $table->foreign('dept_id')->references('id')->on('departments');
            $table->foreign('unit_id')->references('id')->on('units');
        });
        Schema::table('doctor_schedule_details', function (Blueprint $table) {
            $table->foreign('doc_id')->references('id')->on('doctors');
            $table->foreign('dept_id')->references('id')->on('departments');
            $table->foreign('unit_id')->references('id')->on('units');
            $table->foreign('schedule_id')->references('id')->on('schedules');
            $table->foreign('created_unit_id')->references('id')->on('units');
            $table->foreign('updated_unit_id')->references('id')->on('units');
            $table->dateTime('added_date_time')->nullable()->change();
            $table->dateTime('updated_date_time')->nullable()->change();
        });
        Schema::table('doctor_schedule_masters', function (Blueprint $table) {
            $table->foreign('doc_id')->references('id')->on('doctors');
            $table->foreign('dept_id')->references('id')->on('departments');
            $table->foreign('unit_id')->references('id')->on('units');
            $table->foreign('created_unit_id')->references('id')->on('units');
            $table->foreign('updated_unit_id')->references('id')->on('units');
            $table->dateTime('added_date_time')->nullable()->change();
            $table->dateTime('updated_date_time')->nullable()->change();
        });
        Schema::table('doctor_shares', function (Blueprint $table) {
            $table->integer('status')->comment('1:Active,0:Inactive')->default(1)->change();
            $table->unsignedBigInteger('created_unit_id')->nullable()->change();
            $table->unsignedBigInteger('updated_unit_id')->nullable()->change();
            $table->foreign('created_unit_id')->references('id')->on('units');
            $table->foreign('updated_unit_id')->references('id')->on('units');
            $table->dateTime('added_date_time')->nullable()->change();
            $table->dateTime('added_utc_date_time')->nullable()->change();
            $table->dateTime('updated_date_time')->nullable()->change();
            $table->dateTime('updated_utc_date_time')->nullable()->change();
        });
        Schema::table('doctor_share_specializations', function (Blueprint $table) {
            $table->integer('status')->comment('1:Active,0:Inactive')->default(1)->change();
            $table->unsignedBigInteger('created_unit_id')->nullable()->change();
            $table->unsignedBigInteger('updated_unit_id')->nullable()->change();
            $table->foreign('created_unit_id')->references('id')->on('units');
            $table->foreign('updated_unit_id')->references('id')->on('units');
            $table->dateTime('added_date_time')->nullable()->change();
            $table->dateTime('added_utc_date_time')->nullable()->change();
            $table->dateTime('updated_date_time')->nullable()->change();
            $table->dateTime('updated_utc_date_time')->nullable()->change();
        });
        Schema::table('doctor_slot_appointments', function (Blueprint $table) {
            $table->foreign('unit_id')->references('id')->on('units');
            $table->foreign('doc_id')->references('id')->on('doctors');
            $table->foreign('dept_id')->references('id')->on('departments');
            $table->foreign('doc_cat_id')->references('id')->on('doctor_categories');
            $table->foreign('doc_schedule_detail_id')->references('id')->on('doctor_schedule_details');
            $table->foreign('time_slot_id')->references('id')->on('time_slots');
            $table->foreign('appointment_id')->references('id')->on('appointments');
            $table->foreign('created_unit_id')->references('id')->on('units');
            $table->foreign('updated_unit_id')->references('id')->on('units');
            $table->dateTime('added_date_time')->nullable()->change();
            $table->dateTime('updated_date_time')->nullable()->change();
        });
        Schema::table('donor_registrations', function (Blueprint $table) {
            $table->unsignedSmallInteger('patient_category_id')->change();
            $table->foreign('patient_category_id')->references('id')->on('patient_categories');
            $table->foreign('unit_id')->references('id')->on('units');
            $table->foreign('blood_group_id')->references('id')->on('blood_groups');
            $table->foreign('created_unit_id')->references('id')->on('units');
            $table->foreign('updated_unit_id')->references('id')->on('units');
            $table->dateTime('added_date_time')->nullable()->change();
            $table->dateTime('updated_date_time')->nullable()->change();
        });
        Schema::table('expense_masters', function (Blueprint $table) {
            $table->integer('status')->comment('1:Active,0:Inactive')->default(1)->change();
            $table->unsignedBigInteger('created_unit_id')->nullable()->change();
            $table->unsignedBigInteger('updated_unit_id')->nullable()->change();
            $table->foreign('created_unit_id')->references('id')->on('units');
            $table->foreign('updated_unit_id')->references('id')->on('units');
            $table->dateTime('added_date_time')->nullable()->change();
            $table->dateTime('added_utc_date_time')->nullable()->change();
            $table->dateTime('updated_date_time')->nullable()->change();
            $table->dateTime('updated_utc_date_time')->nullable()->change();
        });
        Schema::table('id_proofs', function (Blueprint $table) {
            $table->foreign('created_unit_id')->references('id')->on('units');
            $table->foreign('updated_unit_id')->references('id')->on('units');
            $table->dateTime('added_date_time')->nullable()->change();
            $table->dateTime('added_utc_date_time')->nullable()->change();
            $table->dateTime('updated_date_time')->nullable()->change();
            $table->dateTime('updated_utc_date_time')->nullable()->change();
        });
        Schema::table('mode_of_payments', function (Blueprint $table) {
            $table->unsignedBigInteger('unit_id')->nullable()->change();
            $table->foreign('unit_id')->references('id')->on('units');
            $table->integer('status')->default(1)->comment('1:Active, 0:InActive')->change();
            $table->unsignedBigInteger('created_unit_id')->nullable()->change();
            $table->unsignedBigInteger('updated_unit_id')->nullable()->change();
            $table->foreign('created_unit_id')->references('id')->on('units');
            $table->foreign('updated_unit_id')->references('id')->on('units');
            $table->dateTime('added_date_time')->nullable()->change();
            $table->dateTime('updated_date_time')->nullable()->change();
        });
        Schema::table('molecules', function (Blueprint $table) {
            $table->integer('status')->default(1)->comment('1:Active, 0:InActive')->change();
            $table->foreign('created_unit_id')->references('id')->on('units');
            $table->foreign('updated_unit_id')->references('id')->on('units');
        });
        Schema::table('mrn_formats', function (Blueprint $table) {
            $table->unsignedBigInteger('unit_id')->nullable()->change();
            $table->foreign('unit_id')->references('id')->on('units');
        });
        Schema::table('patient_sources', function (Blueprint $table) {
            $table->unsignedBigInteger('unit_id')->nullable()->change();
            $table->foreign('unit_id')->references('id')->on('units');
            $table->integer('status')->comment('1:Active,0:Inactive')->default(1)->change();
            $table->unsignedBigInteger('created_unit_id')->nullable()->change();
            $table->unsignedBigInteger('updated_unit_id')->nullable()->change();
            $table->foreign('created_unit_id')->references('id')->on('units');
            $table->foreign('updated_unit_id')->references('id')->on('units');
            $table->dateTime('added_date_time')->nullable()->change();
            $table->dateTime('updated_date_time')->nullable()->change();
        });
        Schema::table('patient_sponsor_details', function (Blueprint $table) {
            $table->unsignedBigInteger('company_id')->nullable()->change();
            $table->foreign('company_id')->references('id')->on('company_masters');
            $table->unsignedBigInteger('associated_company_id')->nullable()->change();
            $table->foreign('associated_company_id')->references('id')->on('company_masters');
            $table->integer('status')->comment('1:Active,0:Inactive')->default(1)->change();
            $table->unsignedBigInteger('created_unit_id')->nullable()->change();
            $table->foreign('created_unit_id')->references('id')->on('units');
            $table->unsignedBigInteger('updated_unit_id')->nullable()->change();
            $table->foreign('updated_unit_id')->references('id')->on('units');
            $table->unsignedBigInteger('tariff_id')->nullable()->change();
            $table->foreign('tariff_id')->references('id')->on('tariff_masters');
            $table->dateTime('added_date_time')->nullable()->change();
            $table->dateTime('updated_date_time')->nullable()->change();
        });
        Schema::table('reason_of_refund_masters', function (Blueprint $table) {
            $table->integer('status')->comment('1:Active,0:Inactive')->default(1)->change();
            $table->unsignedBigInteger('created_unit_id')->nullable()->change();
            $table->foreign('created_unit_id')->references('id')->on('units');
            $table->unsignedBigInteger('updated_unit_id')->nullable()->change();
            $table->foreign('updated_unit_id')->references('id')->on('units');
            $table->dateTime('added_date_time')->nullable()->change();
            $table->dateTime('added_utc_date_time')->nullable()->change();
            $table->dateTime('updated_date_time')->nullable()->change();
            $table->dateTime('updated_utc_date_time')->nullable()->change();
        });
        Schema::table('registrations', function (Blueprint $table) {
            $table->unsignedSmallInteger('patient_category_id')->change();
            $table->foreign('patient_category_id')->references('id')->on('patient_categories');
            $table->dateTime('added_date_time')->nullable()->change();
            $table->dateTime('updated_date_time')->nullable()->change();
        });
        Schema::table('role_masters', function (Blueprint $table) {
            $table->foreign('unit_id')->references('id')->on('units');
            $table->dateTime('added_date_time')->nullable()->change();
            $table->dateTime('added_utc_date_time')->nullable()->change();
            $table->dateTime('updated_date_time')->nullable()->change();
            $table->dateTime('updated_utc_date_time')->nullable()->change();
        });
        Schema::table('role_menu_details', function (Blueprint $table) {
            $table->unsignedBigInteger('unit_id')->nullable()->change();
            $table->unsignedBigInteger('role_id')->nullable()->change();
            $table->foreign('unit_id')->references('id')->on('units');
            $table->foreign('role_id')->references('id')->on('role_masters');
            $table->integer('status')->comment('1:Active,0:Inactive')->default(1)->change();
        });
        Schema::table('schedules', function (Blueprint $table) {
            $table->integer('status')->comment('1:Active,0:Inactive')->default(1)->change();
        });
        Schema::table('schedule_details', function (Blueprint $table) {
            $table->foreign('created_unit_id')->references('id')->on('units');
            $table->foreign('updated_unit_id')->references('id')->on('units');
            $table->foreign('doc_schedule_detail_id')->references('id')->on('doctor_schedule_details');
            $table->dateTime('added_date_time')->nullable()->change();
            $table->dateTime('updated_date_time')->nullable()->change();
        });
        Schema::table('service_class_rate_details', function (Blueprint $table) {
            $table->unsignedBigInteger('created_unit_id')->nullable()->change();
            $table->unsignedBigInteger('updated_unit_id')->nullable()->change();
            $table->foreign('created_unit_id')->references('id')->on('units');
            $table->foreign('updated_unit_id')->references('id')->on('units');
            $table->dateTime('added_date_time')->nullable()->change();
            $table->dateTime('added_utc_date_time')->nullable()->change();
            $table->dateTime('updated_date_time')->nullable()->change();
            $table->dateTime('updated_utc_date_time')->nullable()->change();
        });
        Schema::table('slot_schedules', function (Blueprint $table) {
            $table->foreign('created_unit_id')->references('id')->on('units');
            $table->foreign('updated_unit_id')->references('id')->on('units');
            $table->dateTime('added_date_time')->nullable()->change();
            $table->dateTime('added_utc_date_time')->nullable()->change();
            $table->dateTime('updated_date_time')->nullable()->change();
            $table->dateTime('updated_utc_date_time')->nullable()->change();
        });
        Schema::table('source_of_references', function (Blueprint $table) {
            $table->foreign('created_unit_id')->references('id')->on('units');
            $table->foreign('updated_unit_id')->references('id')->on('units');
            $table->dateTime('added_date_time')->nullable()->change();
            $table->dateTime('added_utc_date_time')->nullable()->change();
            $table->dateTime('updated_date_time')->nullable()->change();
            $table->dateTime('updated_utc_date_time')->nullable()->change();
        });
        Schema::table('specializations', function (Blueprint $table) {
            $table->foreign('created_unit_id')->references('id')->on('units');
            $table->foreign('updated_unit_id')->references('id')->on('units');
            $table->dateTime('added_date_time')->nullable()->change();
            $table->dateTime('added_utc_date_time')->nullable()->change();
            $table->dateTime('updated_date_time')->nullable()->change();
            $table->dateTime('updated_utc_date_time')->nullable()->change();
        });
        Schema::table('storage_types', function (Blueprint $table) {
            $table->integer('status')->default(1)->comment('1:Active, 0:Inactive')->change();
            $table->foreign('created_unit_id')->references('id')->on('units');
            $table->foreign('updated_unit_id')->references('id')->on('units');
        });
        Schema::table('stores', function (Blueprint $table) {
            $table->unsignedBigInteger('clinic_id')->nullable()->change();
            $table->foreign('clinic_id')->references('id')->on('units');
            $table->unsignedBigInteger('created_unit_id')->nullable()->change();
            $table->unsignedBigInteger('updated_unit_id')->nullable()->change();
            $table->dateTime('added_date_time')->nullable()->change();
            $table->dateTime('updated_date_time')->nullable()->change();
            $table->integer('status')->default(1)->comment('1:Active, 0:Inactive')->change();
            $table->foreign('created_unit_id')->references('id')->on('units');
            $table->foreign('updated_unit_id')->references('id')->on('units');
        });
        Schema::table('store_item_types', function (Blueprint $table) {
            $table->dateTime('added_date_time')->nullable()->change();
            $table->dateTime('added_utc_date_time')->nullable()->change();
            $table->dateTime('updated_date_time')->nullable()->change();
            $table->dateTime('updated_utc_date_time')->nullable()->change();
        });
        Schema::table('sub_specializations', function (Blueprint $table) {
            $table->foreign('created_unit_id')->references('id')->on('units');
            $table->foreign('updated_unit_id')->references('id')->on('units');
            $table->dateTime('added_date_time')->nullable()->change();
            $table->dateTime('added_utc_date_time')->nullable()->change();
            $table->dateTime('updated_date_time')->nullable()->change();
            $table->dateTime('updated_utc_date_time')->nullable()->change();
        });
        Schema::table('suppliers', function (Blueprint $table) {
            $table->foreign('created_unit_id')->references('id')->on('units');
            $table->foreign('updated_unit_id')->references('id')->on('units');
            $table->dateTime('added_utc_date_time')->nullable()->change();
            $table->dateTime('updated_utc_date_time')->nullable()->change();
        });
        Schema::table('supplier_categories', function (Blueprint $table) {
            $table->foreign('created_unit_id')->references('id')->on('units');
            $table->foreign('updated_unit_id')->references('id')->on('units');
            $table->dateTime('added_utc_date_time')->nullable()->change();
            $table->dateTime('updated_utc_date_time')->nullable()->change();
        });
        Schema::table('tariff_masters', function (Blueprint $table) {
            $table->unsignedBigInteger('unit_id')->nullable()->change();
            $table->foreign('unit_id')->references('id')->on('units');
            $table->integer('status')->comment('1:active,0:inactive')->default(1)->change();
            $table->unsignedBigInteger('created_unit_id')->nullable()->change();
            $table->unsignedBigInteger('updated_unit_id')->nullable()->change();
            $table->foreign('created_unit_id')->references('id')->on('units');
            $table->foreign('updated_unit_id')->references('id')->on('units');
            $table->foreign('service_id')->references('id')->on('service_masters');
            $table->dateTime('added_date_time')->nullable()->change();
            $table->dateTime('added_utc_date_time')->nullable()->change();
            $table->dateTime('updated_date_time')->nullable()->change();
            $table->dateTime('updated_utc_date_time')->nullable()->change();
        });
        Schema::table('units', function (Blueprint $table) {
            $table->unsignedBigInteger('country_id')->nullable()->change();
            $table->unsignedBigInteger('state_id')->nullable()->change();
            $table->unsignedBigInteger('city_id')->nullable()->change();
            $table->foreign('country_id')->references('id')->on('countries');
            $table->foreign('state_id')->references('id')->on('states');
            $table->foreign('city_id')->references('id')->on('cities');
            $table->dateTime('added_date_time')->nullable()->change();
            $table->dateTime('added_utc_date_time')->nullable()->change();
        });
        Schema::table('unit_department_details', function (Blueprint $table) {
            $table->foreign('unit_id')->references('id')->on('units');
            $table->foreign('department_id')->references('id')->on('departments');
        });
        Schema::table('unit_of_measures', function (Blueprint $table) {
            $table->unsignedBigInteger('unit_id')->nullable()->change();
            $table->foreign('unit_id')->references('id')->on('units');
            $table->foreign('created_unit_id')->references('id')->on('units');
            $table->foreign('updated_unit_id')->references('id')->on('units');
            $table->dateTime('added_date_time')->nullable()->change();
        });
        Schema::table('users', function (Blueprint $table) {
            $table->foreign('client_id')->references('id')->on('clients');
        });
        Schema::table('user_roles', function (Blueprint $table) {
            $table->foreign('created_unit_id')->references('id')->on('units');
            $table->foreign('updated_unit_id')->references('id')->on('units');
            $table->dateTime('added_date_time')->nullable()->change();
            $table->dateTime('added_utc_date_time')->nullable()->change();
            $table->dateTime('updated_date_time')->nullable()->change();
        });
        Schema::table('visits', function (Blueprint $table) {
            $table->foreign('department_id')->references('id')->on('departments');
            $table->foreign('doctor_id')->references('id')->on('doctors');
            $table->foreign('referred_doctor_id')->references('id')->on('doctors');
            $table->integer('visit_status')->comment('0:Inactive,1:Active')->default(1)->change();
            $table->integer('current_visit_status')->comment('0:Inactive,1:Active')->default(1)->change();
            $table->unsignedBigInteger('visit_type_service_id')->nullable()->change();
            $table->foreign('visit_type_service_id')->references('id')->on('visit_types');
            $table->foreign('created_unit_id')->references('id')->on('units');
            $table->foreign('updated_unit_id')->references('id')->on('units');
            $table->dateTime('added_date_time')->nullable()->change();
            $table->dateTime('added_utc_date_time')->nullable()->change();
            $table->dateTime('updated_date_time')->nullable()->change();
        });
        DB::statement("SET FOREIGN_KEY_CHECKS = 1;");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement("SET FOREIGN_KEY_CHECKS = 0;");
        Schema::table('batches', function (Blueprint $table) {
            // $table->string('created_unit_id',16)->collation('utf8_general_ci')->nullable()->change();
            // $table->string('updated_unit_id',16)->collation('utf8_general_ci')->nullable()->change();
            $table->dropForeign(['created_unit_id']);
            $table->dropForeign(['updated_unit_id']);
            $table->string('added_date_time',100)->collation('utf8_general_ci')->nullable()->change();
            $table->string('updated_date_time',100)->collation('utf8_general_ci')->nullable()->change();
        });
        Schema::table('items', function (Blueprint $table) {
            $table->dropForeign(['dispensing_id']);
            $table->dropColumn('dispensing_id');
            $table->dropForeign(['storage_type_id']);
            $table->dropColumn('storage_type_id');
            $table->dropForeign(['created_unit_id']);
            $table->dropForeign(['updated_unit_id']);
            $table->string('added_date_time')->nullable()->change();
            $table->integer('status')->nullable()->change();
        });
        Schema::table('item_categories', function (Blueprint $table) {
            $table->integer('status')->nullable()->change();
            $table->dropForeign(['created_unit_id']);
            $table->dropForeign(['updated_unit_id']);
        });
        Schema::table('item_clinics', function (Blueprint $table) {
            $table->integer('status')->comment('1:Active,0:Inactive')->default(1)->nullable()->change();
            // $table->string('created_unit_id',16)->collation('utf8_general_ci')->nullable()->change();
            // $table->string('updated_unit_id',16)->collation('utf8_general_ci')->nullable()->change();
            $table->dropForeign(['created_unit_id']);
            $table->dropForeign(['updated_unit_id']);
            $table->string('added_date_time',100)->collation('utf8_general_ci')->nullable()->change();
            $table->string('added_utc_date_time',100)->collation('utf8_general_ci')->nullable()->change();
            $table->string('updated_date_time',100)->collation('utf8_general_ci')->nullable()->change();
        });
        Schema::table('item_groups', function (Blueprint $table) {
            $table->integer('status')->nullable()->change();
            $table->dropForeign(['created_unit_id']);
            $table->dropForeign(['updated_unit_id']);
        });
        Schema::table('item_margin_masters', function (Blueprint $table) {
            $table->dropForeign(['created_unit_id']);
            $table->dropForeign(['updated_unit_id']);
            $table->string('status', 10)->nullable()->change();
            $table->string('added_utc_date_time',10)->nullable()->change();
            $table->string('updated_utc_date_time',10)->nullable()->change();
        });
        Schema::table('item_movement_masters', function (Blueprint $table) {
            $table->dropForeign(['created_unit_id']);
            $table->dropForeign(['updated_unit_id']);
            $table->string('status', 10)->nullable()->change();
            $table->string('added_utc_date_time',10)->nullable()->change();
            $table->string('updated_utc_date_time',10)->nullable()->change();
        });
        Schema::table('advance_against_details', function (Blueprint $table) {
            $table->integer('status')->comment('0:Inactive,1:Active')->nullable()->change();
            $table->dropForeign(['created_unit_id']);
            $table->dropForeign(['updated_unit_id']);
            $table->dateTime('added_date_time')->nullable()->change();
            $table->renameColumn('added_utc_date_time','Added_utc_date_time');
            $table->string('Added_utc_date_time',10)->nullable()->change();
            $table->string('updated_date_time',10)->nullable()->change();
            $table->string('updated_utc_date_time',10)->nullable()->change();
        });
        Schema::table('appointments', function (Blueprint $table) {
            $table->string('added_date_time')->nullable()->change();
            $table->string('updated_date_time')->nullable()->change();
        });
        Schema::table('appointment_reasons', function (Blueprint $table) {
            $table->string('added_date_time')->nullable()->change();
            $table->string('updated_date_time')->nullable()->change();
            $table->string('updated_utc_date_time')->nullable()->change();
            $table->dropForeign(['created_unit_id']);
            $table->dropForeign(['updated_unit_id']);
        });
        Schema::table('ass_company_tariff_details', function (Blueprint $table) {
            $table->string('added_date_time',16)->nullable()->change();
            $table->string('updated_date_time',16)->nullable()->change();
            // $table->string('created_unit_id',16)->nullable()->change();
            // $table->string('updated_unit_id',16)->nullable()->change();
            $table->dropForeign(['created_unit_id']);
            $table->dropForeign(['updated_unit_id']);
        });
        Schema::table('baby_registrations', function (Blueprint $table) {
            // $table->unsignedBigInteger('patient_category_id')->nullable()->change();
            $table->dropForeign(['patient_category_id']);
            $table->string('added_date_time')->nullable()->change();
            $table->string('updated_date_time')->nullable()->change();
        });
        Schema::table('bulk_rate_changes', function (Blueprint $table) {
            $table->integer('status')->comment('0:Inactive,1:Active')->nullable()->change();
            $table->string('added_date_time',50)->nullable()->change();
            $table->string('added_utc_date_time',50)->nullable()->change();
            $table->string('updated_date_time',50)->nullable()->change();
            $table->string('updated_utc_date_time',50)->nullable()->change();
            // $table->string('created_unit_id',20)->nullable()->change();
            // $table->string('updated_unit_id',20)->nullable()->change();
            $table->dropForeign(['created_unit_id']);
            $table->dropForeign(['updated_unit_id']);
        });
        Schema::table('bulk_rate_change_specializations', function (Blueprint $table) {
            $table->integer('status')->nullable()->change();
        });
        Schema::table('bulk_rate_change_tarrifs', function (Blueprint $table) {
            $table->integer('status')->comment('0:Inactive,1:Active')->nullable()->change();
        });
        Schema::table('code_type_masters', function (Blueprint $table) {
            $table->integer('status')->comment('0:Inactive,1:Active')->nullable()->change();
        });
        Schema::table('company_addresses', function (Blueprint $table) {
            $table->string('status',16)->nullable()->change();
            $table->string('added_date_time',16)->nullable()->change();
            $table->string('updated_date_time',16)->nullable()->change();
        });
        Schema::table('company_associate_masters', function (Blueprint $table) {
            $table->string('status',16)->nullable()->change();
            $table->string('added_date_time',16)->nullable()->change();
            $table->string('updated_date_time',16)->nullable()->change();
        });
        Schema::table('company_masters', function (Blueprint $table) {
            $table->string('status',100)->comment('1:Active,0:Inactive')->nullable()->change();
            $table->string('added_date_time',100)->nullable()->change();
            $table->string('updated_date_time',100)->nullable()->change();
            $table->string('updated_utc_date_time',100)->nullable()->change();
        });
        Schema::table('company_type_masters', function (Blueprint $table) {
            $table->integer('status')->comment('1=Active, 2=Inactive')->nullable()->change();
            // $table->string('created_unit_id',10)->nullable()->change();
            // $table->string('updated_unit_id',10)->nullable()->change();
            $table->dropForeign(['created_unit_id']);
            $table->dropForeign(['updated_unit_id']);
            $table->string('added_date_time',10)->nullable()->change();
            $table->string('added_utc_date_time',10)->nullable()->change();
            $table->string('updated_date_time',10)->nullable()->change();
            $table->string('updated_utc_date_time',10)->nullable()->change();
        });
        Schema::table('con_reason_masters', function (Blueprint $table) {
            $table->integer('status')->comment('1:Active,0:Inactive')->default(1)->change();
            // $table->string('created_unit_id',16)->collation('utf8_general_ci')->nullable()->change();
            // $table->string('updated_unit_id',16)->collation('utf8_general_ci')->nullable()->change();
            $table->dropForeign(['created_unit_id']);
            $table->dropForeign(['updated_unit_id']);
            $table->string('added_date_time',100)->collation('utf8_general_ci')->nullable()->change();
            $table->string('added_utc_date_time',100)->collation('utf8_general_ci')->nullable()->change();
            $table->string('updated_date_time',100)->collation('utf8_general_ci')->nullable()->change();
            $table->string('updated_utc_date_time',100)->collation('utf8_general_ci')->nullable()->change();
        });
        Schema::table('couple_links', function (Blueprint $table) {
            $table->integer('status')->comment('1:Active,0:Inactive')->nullable()->change();
            // $table->integer('created_unit_id')->nullable()->change();
            // $table->integer('updated_unit_id')->nullable()->change();
            $table->dropForeign(['created_unit_id']);
            $table->dropForeign(['updated_unit_id']);
            $table->datetime('added_date_time')->nullable()->change();
            $table->datetime('added_utc_data_time')->nullable()->change();
            $table->datetime('updated_date_time')->nullable()->change();
        });
        Schema::table('departments', function (Blueprint $table) {
            $table->dropForeign(['created_unit_id']);
            $table->dropForeign(['updated_unit_id']);
            $table->string('added_date_time')->nullable()->change();
            $table->string('added_utc_date_time')->nullable()->change();
        });
        Schema::table('dispensings', function (Blueprint $table) {
            $table->integer('status')->nullable()->change();
            $table->dropForeign(['created_unit_id']);
            $table->dropForeign(['updated_unit_id']);
        });
        Schema::table('doctor_categories', function (Blueprint $table) {
            $table->dropForeign(['created_unit_id']);
            $table->dropForeign(['updated_unit_id']);
            $table->string('added_date_time')->nullable()->change();
            $table->string('updated_date_time')->nullable()->change();
        });
        Schema::table('doctor_department_details', function (Blueprint $table) {
            $table->dropForeign(['doc_id']);
            $table->dropForeign(['dept_id']);
            $table->dropForeign(['unit_id']);
        });
        Schema::table('doctor_schedule_details', function (Blueprint $table) {
            $table->dropForeign(['doc_id']);
            $table->dropForeign(['dept_id']);
            $table->dropForeign(['unit_id']);
            $table->dropForeign(['schedule_id']);
            $table->dropForeign(['created_unit_id']);
            $table->dropForeign(['updated_unit_id']);
            $table->string('added_date_time')->nullable()->change();
            $table->string('updated_date_time')->nullable()->change();
        });
        Schema::table('doctor_schedule_masters', function (Blueprint $table) {
            $table->dropForeign(['doc_id']);
            $table->dropForeign(['dept_id']);
            $table->dropForeign(['unit_id']);
            $table->dropForeign(['created_unit_id']);
            $table->dropForeign(['updated_unit_id']);
            $table->string('added_date_time')->nullable()->change();
            $table->string('updated_date_time')->nullable()->change();
        });
        Schema::table('doctor_shares', function (Blueprint $table) {
            $table->integer('status')->comment('1:Active,0:Inactive')->default(1)->nullable()->change();
            // $table->string('created_unit_id',50)->nullable()->change();
            // $table->string('updated_unit_id',50)->nullable()->change();
            $table->dropForeign(['created_unit_id']);
            $table->dropForeign(['updated_unit_id']);
            $table->string('added_date_time',50)->nullable()->change();
            $table->string('added_utc_date_time',50)->nullable()->change();
            $table->string('updated_date_time',50)->nullable()->change();
            $table->string('updated_utc_date_time',50)->nullable()->change();
        });
        Schema::table('doctor_share_specializations', function (Blueprint $table) {
            $table->integer('status')->comment('1:Active,0:Inactive')->default(1)->nullable()->change();
            // $table->string('created_unit_id',50)->nullable()->change();
            // $table->string('updated_unit_id',50)->nullable()->change();
            $table->dropForeign(['created_unit_id']);
            $table->dropForeign(['updated_unit_id']);
            $table->string('added_date_time',50)->nullable()->change();
            $table->string('added_utc_date_time',50)->nullable()->change();
            $table->string('updated_date_time',50)->nullable()->change();
            $table->string('updated_utc_date_time',50)->nullable()->change();
        });
        Schema::table('donor_registrations', function (Blueprint $table) {
            // $table->unsignedBigInteger('patient_category_id')->change();
            $table->dropForeign(['patient_category_id']);
            $table->dropForeign(['unit_id']);
            $table->dropForeign(['blood_group_id']);
            $table->dropForeign(['created_unit_id']);
            $table->dropForeign(['updated_unit_id']);
            $table->string('added_date_time')->nullable()->change();
            $table->string('updated_date_time')->nullable()->change();
        });
        Schema::table('expense_masters', function (Blueprint $table) {
            $table->integer('status')->comment('1:Active,0:Inactive')->nullable()->change();
            // $table->string('created_unit_id',20)->nullable()->change();
            // $table->string('updated_unit_id',20)->nullable()->change();
            $table->dropForeign(['created_unit_id']);
            $table->dropForeign(['updated_unit_id']);
            $table->string('added_date_time',20)->nullable()->change();
            $table->string('added_utc_date_time',20)->nullable()->change();
            $table->string('updated_date_time',20)->nullable()->change();
            $table->string('updated_utc_date_time',20)->nullable()->change();
        });
        Schema::table('id_proofs', function (Blueprint $table) {
            $table->dropForeign(['created_unit_id']);
            $table->dropForeign(['updated_unit_id']);
            $table->string('added_date_time')->nullable()->change();
            $table->string('added_utc_date_time')->nullable()->change();
            $table->string('updated_date_time')->nullable()->change();
            $table->string('updated_utc_date_time')->nullable()->change();
        });
        Schema::table('mode_of_payments', function (Blueprint $table) {
            // $table->integer('unit_id')->nullable()->change();
            $table->dropForeign(['unit_id']);
            $table->integer('status')->default(1)->comment('1:Active, 0:InActive')->change();
            // $table->string('created_unit_id',100)->nullable()->change();
            // $table->string('updated_unit_id',100)->nullable()->change();
            $table->dropForeign(['created_unit_id']);
            $table->dropForeign(['updated_unit_id']);
            $table->string('added_date_time',100)->nullable()->change();
            $table->string('updated_date_time',100)->nullable()->change();
        });
        Schema::table('molecules', function (Blueprint $table) {
            $table->integer('status')->default(1)->comment('1:Active, 0:InActive')->change();
            $table->dropForeign(['created_unit_id']);
            $table->dropForeign(['updated_unit_id']);
        });
        Schema::table('mrn_formats', function (Blueprint $table) {
            // $table->string('unit_id')->nullable()->change();
            $table->dropForeign(['unit_id']);
        });
        Schema::table('patient_sources', function (Blueprint $table) {
            // $table->integer('unit_id')->nullable()->change();
            $table->dropForeign(['unit_id']);
            $table->dropForeign(['created_unit_id']);
            $table->dropForeign(['updated_unit_id']);
            $table->integer('status')->comment('1:Active,0:Inactive')->nullable()->change();
            // $table->integer('created_unit_id')->nullable()->change();
            // $table->string('updated_unit_id',100)->nullable()->change();
            $table->string('added_date_time',100)->nullable()->change();
            $table->string('updated_date_time',100)->nullable()->change();
        });
        Schema::table('patient_sponsor_details', function (Blueprint $table) {
            // $table->string('company_id',100)->nullable()->change();
            $table->dropForeign(['company_id']);
            // $table->string('associated_company_id',100)->nullable()->change();
            $table->dropForeign(['associated_company_id']);
            $table->string('status',100)->comment('1:Active,0:Inactive')->nullable()->change();
            // $table->string('created_unit_id',100)->nullable()->change();
            $table->dropForeign(['created_unit_id']);
            // $table->string('updated_unit_id',100)->nullable()->change();
            $table->dropForeign(['updated_unit_id']);
            // $table->string('tariff_id',100)->nullable()->change();
            $table->dropForeign(['tariff_id']);
            $table->string('added_date_time',100)->nullable()->change();
            $table->string('updated_date_time',100)->nullable()->change();
        });
        Schema::table('reason_of_refund_masters', function (Blueprint $table) {
            $table->integer('status')->comment('1:Active,0:Inactive')->nullable()->change();
            // $table->string('created_unit_id',16)->collation('utf8_general_ci')->nullable()->change();
            $table->dropForeign(['created_unit_id']);
            // $table->string('updated_unit_id',16)->collation('utf8_general_ci')->nullable()->change();
            $table->dropForeign(['updated_unit_id']);
            $table->string('added_date_time',100)->collation('utf8_general_ci')->nullable()->change();
            $table->string('added_utc_date_time',100)->collation('utf8_general_ci')->nullable()->change();
            $table->string('updated_date_time',100)->collation('utf8_general_ci')->nullable()->change();
            $table->string('updated_utc_date_time',100)->collation('utf8_general_ci')->nullable()->change();
        });
        Schema::table('registrations', function (Blueprint $table) {
            // $table->unsignedBigInteger('patient_category_id')->change();
            $table->dropForeign(['patient_category_id']);
            $table->string('added_date_time')->nullable()->change();
            $table->string('updated_date_time')->nullable()->change();
        });
        Schema::table('role_masters', function (Blueprint $table) {
            $table->dropForeign(['unit_id']);
            $table->string('added_date_time')->nullable()->change();
            $table->string('added_utc_date_time')->nullable()->change();
            $table->string('updated_date_time')->nullable()->change();
            $table->string('updated_utc_date_time')->nullable()->change();
        });
        Schema::table('role_menu_details', function (Blueprint $table) {
            // $table->integer('unit_id')->nullable()->change();
            // $table->integer('role_id')->nullable()->change();
            $table->dropForeign(['unit_id']);
            $table->dropForeign(['role_id']);
            $table->integer('status')->nullable()->change();
        });
        Schema::table('schedules', function (Blueprint $table) {
            $table->integer('status')->default(1)->comment('1= active, 0=inactive')->change();
        });
        Schema::table('schedule_details', function (Blueprint $table) {
            $table->dropForeign(['created_unit_id']);
            $table->dropForeign(['updated_unit_id']);
            $table->dropForeign(['doc_schedule_detail_id']);
            $table->string('added_date_time')->nullable()->change();
            $table->string('updated_date_time')->nullable()->change();
        });
        Schema::table('service_class_rate_details', function (Blueprint $table) {
            // $table->string('created_unit_id',16)->collation('utf8_general_ci')->nullable()->change();
            // $table->string('updated_unit_id',16)->collation('utf8_general_ci')->nullable()->change();
            $table->dropForeign(['created_unit_id']);
            $table->dropForeign(['updated_unit_id']);
            $table->string('added_date_time')->nullable()->change();
            $table->string('updated_date_time')->nullable()->change();
        });
        Schema::table('slot_schedules', function (Blueprint $table) {
            $table->dropForeign(['created_unit_id']);
            $table->dropForeign(['updated_unit_id']);
            $table->string('added_date_time')->nullable()->change();
            $table->string('added_utc_date_time')->nullable()->change();
            $table->string('updated_date_time')->nullable()->change();
            $table->string('updated_utc_date_time')->nullable()->change();
        });
        Schema::table('source_of_references', function (Blueprint $table) {
            $table->dropForeign(['created_unit_id']);
            $table->dropForeign(['updated_unit_id']);
            $table->string('added_date_time')->nullable()->change();
            $table->string('added_utc_date_time')->nullable()->change();
            $table->string('updated_date_time')->nullable()->change();
            $table->string('updated_utc_date_time')->nullable()->change();
        });
        Schema::table('specializations', function (Blueprint $table) {
            $table->dropForeign(['created_unit_id']);
            $table->dropForeign(['updated_unit_id']);
            $table->string('added_date_time')->nullable()->change();
            $table->string('added_utc_date_time')->nullable()->change();
            $table->string('updated_date_time')->nullable()->change();
            $table->string('updated_utc_date_time')->nullable()->change();
        });
        Schema::table('storage_types', function (Blueprint $table) {
            $table->integer('status')->nullable()->change();
            $table->dropForeign(['created_unit_id']);
            $table->dropForeign(['updated_unit_id']);
        });
        Schema::table('stores', function (Blueprint $table) {
            // $table->string('clinic_id',100)->nullable()->change();
            $table->dropForeign(['clinic_id']);
            $table->dropForeign(['created_unit_id']);
            $table->dropForeign(['updated_unit_id']);
            // $table->string('created_unit_id',100)->nullable()->change();
            // $table->string('updated_unit_id',100)->nullable()->change();
            $table->string('added_date_time',100)->nullable()->change();
            $table->string('updated_date_time',100)->nullable()->change();
            $table->string('status',100)->comment('1:Active,0:Inactive')->nullable()->change();
        });
        Schema::table('store_item_types', function (Blueprint $table) {
            $table->string('added_date_time',50)->nullable()->change();
            $table->string('added_utc_date_time',50)->nullable()->change();
            $table->string('updated_date_time',50)->nullable()->change();
            $table->string('updated_utc_date_time',50)->nullable()->change();
        });
        Schema::table('sub_specializations', function (Blueprint $table) {
            $table->dropForeign(['created_unit_id']);
            $table->dropForeign(['updated_unit_id']);
            $table->string('added_date_time')->nullable()->change();
            $table->string('added_utc_date_time')->nullable()->change();
            $table->string('updated_date_time')->nullable()->change();
            $table->string('updated_utc_date_time')->nullable()->change();
        });
        Schema::table('suppliers', function (Blueprint $table) {
            $table->dropForeign(['created_unit_id']);
            $table->dropForeign(['updated_unit_id']);
            $table->string('added_utc_date_time',10)->nullable()->change();
            $table->string('updated_utc_date_time',10)->change();
        });
        Schema::table('supplier_categories', function (Blueprint $table) {
            $table->dropForeign(['created_unit_id']);
            $table->dropForeign(['updated_unit_id']);
            $table->string('added_utc_date_time',10)->nullable()->change();
            $table->string('updated_utc_date_time',10)->change();
        });
        Schema::table('tariff_masters', function (Blueprint $table) {
            // $table->integer('unit_id')->nullable()->change();
            $table->dropForeign(['unit_id']);
            $table->integer('status')->comment('1:active,0:inactive')->nullable()->change();
            // $table->string('created_unit_id',100)->nullable()->change();
            // $table->string('updated_unit_id',100)->nullable()->change();
            $table->dropForeign(['created_unit_id']);
            $table->dropForeign(['updated_unit_id']);
            $table->dropForeign(['service_id']);
            $table->string('added_date_time',100)->nullable()->change();
            $table->string('added_utc_date_time',100)->nullable()->change();
            $table->string('updated_date_time',100)->nullable()->change();
            $table->string('updated_utc_date_time',100)->nullable()->change();
        });
        Schema::table('units', function (Blueprint $table) {
            // $table->smallInteger('country_id')->nullable()->change();
            // $table->smallInteger('state_id')->nullable()->change();
            // $table->smallInteger('city_id')->nullable()->change();
            $table->dropForeign(['country_id']);
            $table->dropForeign(['state_id']);
            $table->dropForeign(['city_id']);
            $table->string('added_date_time')->nullable()->change();
            $table->string('added_utc_date_time')->nullable()->change();
        });
        Schema::table('unit_department_details', function (Blueprint $table) {
            $table->dropForeign(['unit_id']);
            $table->dropForeign(['department_id']);
        });
        Schema::table('unit_of_measures', function (Blueprint $table) {
            $table->unsignedBigInteger('unit_id')->change();
            $table->dropForeign(['unit_id']);
            $table->dropForeign(['created_unit_id']);
            $table->dropForeign(['updated_unit_id']);
            $table->string('added_date_time')->nullable()->change();
        });
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['client_id']);
        });
        Schema::table('user_roles', function (Blueprint $table) {
            $table->dropForeign(['created_unit_id']);
            $table->dropForeign(['updated_unit_id']);
            $table->string('added_date_time')->nullable()->change();
            $table->string('added_utc_date_time')->nullable()->change();
            $table->string('updated_date_time')->nullable()->change();
        });
        Schema::table('visits', function (Blueprint $table) {
            $table->dropForeign(['department_id']);
            $table->dropForeign(['doctor_id']);
            $table->dropForeign(['referred_doctor_id']);
            $table->integer('visit_status')->comment('0:Inactive,1:Active')->nullable()->change();
            $table->integer('current_visit_status')->comment('0:Inactive,1:Active')->nullable()->change();
            // $table->unsignedInteger('visit_type_service_id')->nullable()->change();
            $table->dropForeign(['visit_type_service_id']);
            $table->dropForeign(['created_unit_id']);
            $table->dropForeign(['updated_unit_id']);
            $table->string('added_date_time')->nullable()->change();
            $table->string('added_utc_date_time')->nullable()->change();
            $table->string('updated_date_time')->nullable()->change();
        });
        DB::statement("SET FOREIGN_KEY_CHECKS = 1;");
    }
    
}
