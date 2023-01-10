<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CreateBillMastersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::dropIfExists('bill_masters');
        Schema::create('bill_masters', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('bill_unit_id')->nullable();
            $table->date('date')->nullable();
            $table->integer('bill_type')->nullable();
            $table->unsignedBigInteger('visit_id')->nullable();
            $table->unsignedBigInteger('visit_unit_id')->nullable();
            $table->unsignedBigInteger('admission_id')->nullable();
            $table->unsignedBigInteger('admission_unit_id')->nullable();
            $table->boolean('is_against_donor')->nullable();
            $table->unsignedBigInteger('patient_id')->nullable();
            $table->unsignedBigInteger('patient_unit_id')->nullable();
            $table->unsignedBigInteger('cash_counter_id')->nullable();
            $table->unsignedBigInteger('company_id')->nullable();
            $table->unsignedBigInteger('patient_source_id')->nullable();
            $table->unsignedSmallInteger('patient_category_id')->nullable();
            $table->unsignedBigInteger('tariff_id')->nullable();
            $table->string('comp_ref_no', 32)->nullable();
            $table->date('expirydate')->nullable();
            $table->unsignedBigInteger('camp_id')->nullable();
            $table->integer('bill_no')->nullable();
            $table->integer('inter_or_final')->nullable();
            $table->double('total_bill_amount')->default('0.00');
            $table->double('total_settle_disc_amount')->default('0.00');
            $table->double('total_concession_amount')->default('0.00');
            $table->double('net_bill_amount')->default('0.00');
            $table->double('self_amount')->default('0.00');
            $table->double('non_self_amount')->default('0.00');
            $table->double('balance_amount_self')->default('0.00');
            $table->double('balance_amount_non_self')->default('0.00');
            $table->double('cr_amount')->default('0.00');
            $table->boolean('is_free')->nullable();
            $table->boolean('is_settled')->nullable();
            $table->boolean('is_cancelled')->nullable();
            $table->boolean('is_printed')->nullable();
            $table->timestamp('cancellation_date')->nullable();
            $table->timestamp('cancellation_time')->nullable();
            $table->string('cancellation_reason')->nullable();
            $table->string('concession_authorized_by')->nullable();
            $table->integer('sponser_type')->nullable();
            $table->string('bill_cancellation_remark')->nullable();
            $table->string('remark')->nullable();
            $table->string('claim_no')->nullable();
            $table->string('bill_remark')->nullable();
            $table->tinyInteger('status')->default(1)->comment('1= active, 0=inactive');
            $table->unsignedBigInteger('created_unit_id')->nullable();
            $table->unsignedBigInteger('updated_unit_id')->nullable();
            $table->string('added_by')->nullable();
            $table->string('added_on')->nullable();
            $table->timestamp('added_date_time')->nullable();
            $table->string('added_windows_login_name')->nullable();
            $table->string('updated_by')->nullable();
            $table->string('updated_on')->nullable();
            $table->timestamp('updated_date_time')->nullable();
            $table->string('updated_windows_login_name')->nullable();
            $table->boolean('is_freezed')->nullable();
            $table->timestamp('company_bill_cancel_date')->nullable();
            $table->string('company_bill_cancel_reason')->nullable();
            $table->boolean('is_invoice_generated')->nullable();
            $table->double('calculated_net_bill_amount')->default('0.00');
            $table->unsignedBigInteger('concession_reason_id')->nullable();
            $table->string('concession_remark')->nullable();
            $table->integer('against_donor')->nullable();
            $table->tinyInteger('synchronized')->default(1)->comment('1= active, 0=inactive');
            $table->timestamp('created_at')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->timestamp('updated_at')->nullable()->default(DB::raw('CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP'));

            $table->foreign('visit_id')->references('id')->on('visits');
            $table->foreign('patient_id')->references('id')->on('registrations');
            $table->foreign('cash_counter_id')->references('id')->on('cash_counters');
            $table->foreign('company_id')->references('id')->on('company_masters');
            $table->foreign('patient_source_id')->references('id')->on('patient_sources');
            $table->foreign('patient_category_id')->references('id')->on('patient_categories');
            $table->foreign('tariff_id')->references('id')->on('tariff_masters');
            $table->foreign('camp_id')->references('id')->on('camp_masters');
            $table->foreign('concession_reason_id')->references('id')->on('con_reason_masters');
           
            $table->foreign('bill_unit_id')->references('id')->on('units');
            $table->foreign('visit_unit_id')->references('id')->on('units');
            // $table->foreign('admission_id')->references('id')->on('users');
            // $table->foreign('admission_unit_id')->references('id')->on('units');
            $table->foreign('patient_unit_id')->references('id')->on('units');
            $table->foreign('created_unit_id')->references('id')->on('units');
            $table->foreign('updated_unit_id')->references('id')->on('units');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('bill_masters');
    }
}
