<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePatientSourcesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('patient_sources', function (Blueprint $table) {
            $table->id();
            $table->integer('unit_id')->nullable();
            $table->integer('code')->nullable();
            $table->string('description',100)->nullable();
            $table->integer('status')->comment('1:Active,0:Inactive')->nullable();
            $table->integer('created_unit_id')->nullable();
            $table->string('updated_unit_id',100)->nullable();
            $table->integer('added_by')->nullable();
            $table->string('added_on',100)->nullable();
            $table->string('added_date_time',100)->nullable();
            $table->string('updated_by',100)->nullable();
            $table->string('updated_on',100)->nullable();
            $table->string('updated_date_time',100)->nullable();
            $table->string('added_windows_login_name',100)->nullable();
            $table->string('update_windows_login_name',100)->nullable();
            $table->integer('synchronized')->nullable();
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
        Schema::dropIfExists('patient_sources');
    }
}
