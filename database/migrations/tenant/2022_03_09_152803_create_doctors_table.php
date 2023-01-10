<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateDoctorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('doctors', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('s_id')->nullable();
            $table->unsignedBigInteger('su_id')->nullable();
            $table->unsignedBigInteger('doc_cat_id')->nullable();
            $table->unsignedBigInteger('doc_type_id')->nullable();
            $table->unsignedBigInteger('unit_id');
            $table->unsignedBigInteger('user_id');
            $table->string('employee_no')->nullable();
            $table->string('first_name')->nullable();
            $table->string('middle_name')->nullable();
            $table->string('last_name')->nullable();
            $table->unsignedBigInteger('gender_id')->nullable();
            $table->date('date_of_birth')->nullable();
            $table->string('education')->nullable();
            $table->string('experience')->nullable();
            $table->unsignedBigInteger('registration_number')->nullable();
            $table->string('signature')->nullable();
            $table->boolean('is_referral')->default(0);
            $table->unsignedBigInteger('bdm_id')->nullable();
            $table->date('date_of_joining')->nullable();
            $table->string('pan_no')->nullable();
            $table->string('medical_reg_no')->nullable();
            $table->string('medical_pan_no')->nullable();
            $table->tinyInteger('status')->default(1)->comment('1= active, 0=inactive');
            $table->string('added_by')->nullable();
            $table->string('added_on')->nullable();
            $table->string('added_date_time')->nullable();
            $table->string('updated_by')->nullable();
            $table->string('updated_on')->nullable();
            $table->string('updated_date_time')->nullable();
            $table->string('added_windows_login_name')->nullable();
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
        Schema::dropIfExists('doctors');
    }
}
