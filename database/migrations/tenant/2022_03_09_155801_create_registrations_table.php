<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateRegistrationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('registrations', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('patient_category_id')->nullable();
            $table->text('mrn_number')->nullable();
            $table->string('registration_type', 50);
            $table->string('first_name', 50);
            $table->string('middle_name', 50)->nullable();
            $table->string('last_name', 50);
            $table->longText('profile_image')->nullable();
            $table->string('gender', 10)->nullable();
            $table->string('contact_no', 16)->nullable();
            $table->string('email_address', 90)->unique();
            $table->date('date_of_birth')->nullable();
            $table->smallInteger('age')->nullable();
            $table->string('identity_proof', 100)->nullable();
            $table->string('identity_proof_no', 50)->nullable();
            $table->string('identity_file')->nullable();
            $table->string('source_reference', 100)->nullable();
            $table->string('reference_details', 100)->nullable();
            $table->string('referral_doctor', 100)->nullable();
            $table->string('remark', 100)->nullable();
            $table->string('marital_status', 20)->nullable();
            $table->string('blood_group', 20)->nullable();
            $table->string('nationality', 50)->nullable();
            $table->string('ethnicity', 50)->nullable();
            $table->string('religion', 50)->nullable();
            $table->string('education', 20)->nullable();
            $table->string('occuption', 20)->nullable();
            $table->string('married_since', 20)->nullable();
            $table->string('existing_children', 20)->nullable();
            $table->string('family', 20)->nullable();
            $table->string('address_line_1')->nullable();
            $table->string('address_line_2')->nullable();
            $table->string('landmark', 50)->nullable();
            $table->string('country', 50)->nullable();
            $table->string('state', 50)->nullable();
            $table->string('city', 50)->nullable();
            $table->string('zip_code', 10)->nullable();
            $table->boolean('same_for_partner')->default(0);
            $table->boolean('for_communication')->default(0);
            $table->boolean('notify_me')->default(0);
            $table->string('patient_source', 100)->nullable();
            $table->string('company_name', 200)->nullable();
            $table->string('associated_company', 200)->nullable();
            $table->string('reference_no', 100)->nullable();
            $table->string('tarrif_name', 100)->nullable();
            $table->date('registration_date')->nullable();
            $table->string('doctor')->nullable();
            $table->longText('reason')->nullable();
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
        Schema::dropIfExists('registrations');
    }
}
