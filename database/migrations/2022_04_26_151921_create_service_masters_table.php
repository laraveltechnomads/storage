<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateServiceMastersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('service_masters', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('unit_id')->index();
            $table->foreign('unit_id')->references('id')->on('units')->onDelete('cascade'); 
            $table->integer('service_code')->nullable();
            $table->string('code_type',10)->nullable();
            $table->string('code',10)->nullable();
            $table->integer('specialization_id')->nullable();
            $table->integer('sub_specialization_id')->nullable();
            $table->string('description',40)->nullable();
            $table->string('short_description',40)->nullable();
            $table->string('long_description',40)->nullable();
            $table->integer('staff_discount')->nullable();
            $table->string('staff_discount_amount',40)->nullable();
            $table->string('staff_discount_percent',40)->nullable();
            $table->integer('staff_dependant_discount')->nullable();
            $table->string('staff_dependant_discount_amount',40)->nullable();
            $table->string('staff_dependant_discount_percent',40)->nullable();
            $table->integer('general_discount')->nullable();
            $table->integer('concession')->nullable();
            $table->string('concession_amount',10)->nullable();
            $table->string('concession_percent',10)->nullable();
            $table->integer('service_tax')->nullable();
            $table->string('service_tax_amount',10)->nullable();
            $table->string('service_tax_percent',10)->nullable();
            $table->string('luxury_tax_amount',10)->nullable();
            $table->string('luxury_tax_percent',10)->nullable();
            $table->integer('out_source')->nullable();
            $table->integer('in_house')->nullable();
            $table->integer('doctor_share')->nullable();
            $table->string('doctor_share_percentage',20)->nullable();
            $table->string('doctor_share_amount',20)->nullable();
            $table->integer('rate_editable')->nullable();
            $table->string('max_rate',20)->nullable();
            $table->string('min_rate',20)->nullable();
            $table->integer('status')->comment('1:Active,0:Inactive')->nullable();
            $table->integer('created_unit_id')->nullable();
            $table->string('updated_unit_id',20)->nullable();
            $table->integer('added_by')->nullable();
            $table->string('added_on',20)->nullable();
            $table->string('added_date_time',20)->nullable();
            $table->string('updated_by',20)->nullable();
            $table->string('updated_on',20)->nullable();
            $table->string('updated_date_time',20)->nullable();
            $table->string('added_windows_login_name',20)->nullable();
            $table->string('update_windows_login_name',20)->nullable();
            $table->integer('applicable_to')->nullable();
            $table->integer('holiday_app_to')->nullable();
            $table->integer('is_package')->nullable();
            $table->integer('admin_charges')->nullable();
            $table->integer('free')->nullable();
            $table->integer('conces_senior')->nullable();
            $table->integer('conces_holiday')->nullable();
            $table->integer('installment')->nullable();
            $table->integer('op_package_app')->nullable();
            $table->integer('emergency')->nullable();
            $table->integer('is_external')->nullable();
            $table->integer('staff_pdd')->nullable();
            $table->integer('staff_pdd_per')->nullable();
            $table->integer('staff_dd')->nullable();
            $table->integer('staff_dd_per')->nullable();
            $table->integer('billable')->nullable();
            $table->integer('comp_id')->nullable();
            $table->string('valid_date_for_pack',20)->nullable();
            $table->string('applicable_from',20)->nullable();
            $table->integer('is_approved')->nullable();
            $table->integer('approved_by')->nullable();
            $table->string('date',20)->nullable();
            $table->string('time',20)->nullable();
            $table->integer('trans_app')->nullable();
            $table->integer('package_activity_days')->nullable();
            $table->integer('healthplan_package')->nullable();
            $table->integer('print_order')->nullable();
            $table->integer('app_for_all_doctors')->nullable();
            $table->integer('doctor_percent')->nullable();
            $table->integer('doctor_amount')->nullable();
            $table->integer('is_display_on_detail_bill')->nullable();
            $table->integer('is_ot_procedure')->nullable();
            $table->integer('synchronized')->nullable();
            $table->integer('senior_citizen')->nullable();
            $table->string('senior_citizen_age',10)->nullable();
            $table->string('senior_citizen_con_amount',10)->nullable();
            $table->string('senior_citizen_con_percent',10)->nullable();
            $table->integer('is_favourite')->nullable();
            $table->integer('is_link_with_inventory')->nullable();
            $table->string('code_details',10)->nullable();
            $table->integer('base_service_rate')->nullable();
            $table->integer('is_mark_up')->nullable();
            $table->integer('is_favorite')->nullable();
            $table->string('percentage_on_mrp',10)->nullable();
            $table->string('package_effective_date',10)->nullable();
            $table->string('package_expiry_date',10)->nullable();
            $table->integer('is_family')->nullable();
            $table->string('family_member_count',10)->nullable();
            $table->string('sac_code_id',10)->nullable();
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
        Schema::dropIfExists('service_masters');
    }
}
