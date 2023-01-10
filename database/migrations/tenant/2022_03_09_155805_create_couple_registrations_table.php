<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateCoupleRegistrationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::dropIfExists('couple_registrations'); 

        Schema::create('couple_registrations', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('unit_id')->nullable();
            $table->unsignedBigInteger('registration_number')->nullable();
            $table->unsignedBigInteger('mrn_number')->nullable()->nullable();
            $table->unsignedBigInteger('male_patient_id')->nullable();
            $table->unsignedBigInteger('male_patient_unit_id')->nullable();
            $table->unsignedBigInteger('female_patient_id')->nullable();
            $table->unsignedBigInteger('female_patient_unit_id')->nullable();
            $table->timestamp('registration_date')->nullable();
            $table->tinyInteger('status')->default(1)->comment('1= active, 0=inactive');
            $table->string('added_by')->nullable();
            $table->string('added_on')->nullable();
            $table->string('updated_by')->nullable();
            $table->string('updated_on')->nullable();
            $table->string('added_windows_login_name')->nullable();
            $table->string('updated_windows_login_name')->nullable();
            $table->tinyInteger('synchronized')->default(0)->comment('1= yes, 0=no');
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
        Schema::dropIfExists('couple_registrations');
    }
}