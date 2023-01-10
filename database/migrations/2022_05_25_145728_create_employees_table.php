<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateEmployeesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('employees', function (Blueprint $table) {
            $table->id();
            $table->string('name')->collation('utf8_general_ci')->nullable();
            $table->unsignedBigInteger('skill_id')->nullable();
            $table->date('dob')->nullable();
            $table->unsignedBigInteger('gender')->nullable();
            $table->unsignedBigInteger('marital_status')->nullable();
            $table->string('image')->nullable();
            $table->unsignedBigInteger('image_id')->nullable();
            $table->string('image_name')->collation('utf8_general_ci')->nullable();
            $table->string('image_data')->collation('utf8_general_ci')->nullable();
            $table->string('image_mime')->collation('utf8_general_ci')->nullable();

            
            

            $table->string('first_name')->collation('utf8_general_ci')->nullable();
            $table->string('last_name')->collation('utf8_general_ci')->nullable();
            $table->string('mobile_number')->collation('utf8_general_ci')->unique()->nullable();
            $table->unsignedBigInteger('blood_group_id')->nullable();
            $table->text('address')->collation('utf8_general_ci')->nullable();
            $table->unsignedBigInteger('designation_id')->nullable();
            $table->unsignedBigInteger('unit_id')->nullable();
            $table->date('date_of_joining')->nullable();
            $table->string('employee_no',100)->nullable();
            $table->string('pf_no')->collation('utf8_general_ci')->nullable();
            $table->string('pan_no')->collation('utf8_general_ci')->nullable();
            $table->string('email_address', 90)->collation('utf8_general_ci')->unique()->nullable();
            $table->integer('access_card_no')->nullable();
            $table->string('education')->nullable();
            $table->boolean('discharge_approval')->default(0);
            $table->tinyInteger('status')->default(1)->comment('1=active, 0=inactive');
            $table->timestamp('created_at')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->timestamp('updated_at')->nullable()->default(DB::raw('CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP'));

            $table->foreign('gender')->references('id')->on('genders');
            $table->foreign('marital_status')->references('id')->on('marital_statuses');
            $table->foreign('blood_group_id')->references('id')->on('blood_groups');
            $table->foreign('designation_id')->references('id')->on('designation_masters');
            $table->foreign('unit_id')->references('id')->on('units');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('employees');
    }
}
