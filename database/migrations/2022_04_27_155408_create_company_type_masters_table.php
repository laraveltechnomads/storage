<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateCompanyTypeMastersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('company_type_masters', function (Blueprint $table) {
            $table->id();
            $table->string('comp_type_code',10)->nullable();
            $table->string('description',100)->nullable();
            $table->integer('status')->comment('1=Active, 2=Inactive')->nullable();
            $table->string('created_unit_id',10)->nullable();
            $table->string('updated_unit_id',10)->nullable();
            $table->string('added_by',10)->nullable();
            $table->string('added_on',10)->nullable();
            $table->string('added_date_time',10)->nullable();
            $table->string('added_utc_date_time',10)->nullable();
            $table->string('updated_by',10)->nullable();
            $table->string('updated_on',10)->nullable();
            $table->string('updated_date_time',10)->nullable();
            $table->string('updated_utc_date_time',10)->nullable();
            $table->string('added_windows_login_name',10)->nullable();
            $table->string('update_windows_login_name',10)->nullable();
            $table->string('synchronized',10)->nullable();
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
        Schema::dropIfExists('company_type_masters');
    }
}
