<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateBabyRegistrationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('baby_registrations', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('patient_category_id')->nullable();
            $table->bigInteger('couple_registration_number')->unsigned()->nullable();
            $table->string('registration_type', 50)->nullable();
            $table->text('mrn_number')->nullable();
            $table->string('parent_id', 50)->nullable();
            $table->string('first_name', 50)->nullable();
            $table->string('middle_name', 50)->nullable();
            $table->string('last_name', 50)->nullable();
            $table->longText('profile_image')->nullable();
            $table->string('gender', 10)->nullable();
            $table->string('contact_no', 16)->nullable();
            $table->date('date_of_birth')->nullable();
            $table->time('birth_time')->nullable();
            $table->string('birth_weight', 20)->nullable();
            $table->string('weight_type', 20)->nullable();
            $table->string('blood_group', 20)->nullable();
            $table->string('identity_proof', 100)->nullable();
            $table->string('identity_proof_no', 50)->nullable();
            $table->string('identity_file')->nullable();
            $table->date('registration_date')->nullable();
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
            $table->foreign('couple_registration_number')->references('id')->on('couple_registrations')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('baby_registrations');
    }
}
