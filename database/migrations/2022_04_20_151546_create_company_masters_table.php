<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateCompanyMastersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('company_masters', function (Blueprint $table) {
            $table->id();
            $table->string('comp_unit_id',100)->nullable();
            $table->string('comp_code',100)->nullable();
            $table->string('description',100)->nullable();
            $table->unsignedBigInteger('comp_type_id')->nullable();
            $table->unsignedBigInteger('patient_source_id')->nullable();
            $table->foreign('patient_source_id')->references('id')->on('patient_sources')->onDelete('cascade');   
            $table->string('status',100)->comment('1:Active,0:Inactive')->nullable();
            $table->text('tariff_list')->nullable();
            $table->text('header_text')->nullable();
            $table->text('footer_text')->nullable();
            $table->string('logo',255)->nullable();
            $table->string('header_image',255)->nullable();
            $table->string('footer_image',255)->nullable();
            $table->string('created_unit_id',100)->nullable();
            $table->string('updated_unit_id',100)->nullable();
            $table->string('added_by',100)->nullable();
            $table->string('added_on',100)->nullable();
            $table->string('added_date_time',100)->nullable();
            $table->string('updated_by',100)->nullable();
            $table->string('updated_on',100)->nullable();
            $table->string('updated_date_time',100)->nullable();
            $table->string('updated_utc_date_time',100)->nullable();
            $table->string('added_windows_login_name',100)->nullable();
            $table->string('update_windows_login_name',100)->nullable();
            $table->string('synchronized',100)->nullable();
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
        Schema::dropIfExists('company_masters');
    }
}
