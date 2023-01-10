<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateDonorRegistrationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('donor_registrations', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('patient_category_id');
            $table->unsignedBigInteger('registration_number')->nullable();
            $table->text('mrn_number')->nullable();
            $table->unsignedBigInteger('unit_id')->nullable();
            $table->unsignedBigInteger('donor_code')->nullable();
            $table->timestamp('registration_date')->nullable();
            $table->unsignedBigInteger('agnecy_id')->nullable();
            $table->unsignedBigInteger('blood_group_id')->nullable();
            $table->unsignedBigInteger('eye_color_id')->nullable();
            $table->unsignedBigInteger('hair_color_id')->nullable();
            $table->unsignedBigInteger('skin_color_id')->nullable();
            $table->unsignedBigInteger('height_id')->nullable();
            $table->unsignedBigInteger('built_id')->nullable();
            $table->unsignedBigInteger('added_user_id')->nullable();
            $table->unsignedBigInteger('created_unit_id')->nullable();
            $table->unsignedBigInteger('updated_unit_id')->nullable();
            $table->string('added_by')->nullable();
            $table->string('added_on')->nullable();
            $table->string('added_date_time')->nullable();
            $table->string('updated_by')->nullable();
            $table->string('updated_on')->nullable();
            $table->string('updated_date_time')->nullable();
            $table->string('added_windows_login_name')->nullable();
            $table->string('updated_windows_login_name')->nullable();
            $table->tinyInteger('synchronized')->default(1)->comment('1= active, 0=inactive');
            $table->unsignedBigInteger('education_id')->nullable();
            $table->timestamp('created_at')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->timestamp('updated_at')->nullable()->default(DB::raw('CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP'));
            $table->foreign('registration_number')->references('id')->on('registrations')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('donor_registrations');
    }
}
