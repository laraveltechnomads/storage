<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePatientVitalMastersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('patient_vital_masters', function (Blueprint $table) {
            $table->id();
            $table->string('code',20)->nullable();
            $table->string('description')->collation('utf8_general_ci')->nullable();
            $table->double('default_val')->nullable();
            $table->double('min_value')->nullable();
            $table->double('max_value')->nullable();
            $table->string('unit_name')->collation('utf8_general_ci')->nullable();
            $table->tinyInteger('status')->default(1)->comment('1:Active,0:Inactive');
            $table->unsignedBigInteger('created_unit_id')->nullable();
            $table->unsignedBigInteger('updated_unit_id')->nullable();
            $table->string('added_by',50)->collation('utf8_general_ci')->nullable();
            $table->string('added_on',50)->collation('utf8_general_ci')->nullable();
            $table->timestamp('added_date_time')->nullable();
            $table->timestamp('added_utc_date_time')->nullable();
            $table->string('updated_by',50)->collation('utf8_general_ci')->nullable();
            $table->timestamp('updated_date_time')->nullable();
            $table->timestamp('updated_utc_date_time')->nullable();
            $table->string('added_windows_login_name',50)->collation('utf8_general_ci')->nullable();
            $table->string('update_windows_login_name',50)->collation('utf8_general_ci')->nullable();
            $table->string('synchronized',50)->collation('utf8_general_ci')->nullable();
            $table->foreign('created_unit_id')->references('id')->on('units');
            $table->foreign('updated_unit_id')->references('id')->on('units');
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
        Schema::dropIfExists('patient_vital_masters');
    }
}
