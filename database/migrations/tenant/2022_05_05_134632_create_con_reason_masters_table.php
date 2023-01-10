<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateConReasonMastersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('con_reason_masters', function (Blueprint $table) {
            $table->id();
            $table->string('con_r_code',16)->collation('utf8_general_ci')->nullable();
            $table->string('con_r_description',200)->collation('utf8_general_ci')->nullable();
            $table->integer('status')->comment('1:Active,0:Inactive')->nullable();
            $table->string('created_unit_id',16)->collation('utf8_general_ci')->nullable();
            $table->string('updated_unit_id',16)->collation('utf8_general_ci')->nullable();
            $table->string('added_by',100)->collation('utf8_general_ci')->nullable();
            $table->string('added_on',100)->collation('utf8_general_ci')->nullable();
            $table->string('added_date_time',100)->collation('utf8_general_ci')->nullable();
            $table->string('added_utc_date_time',100)->collation('utf8_general_ci')->nullable();
            $table->string('updated_by',100)->collation('utf8_general_ci')->nullable();
            $table->string('updated_date_time',100)->collation('utf8_general_ci')->nullable();
            $table->string('updated_utc_date_time',100)->collation('utf8_general_ci')->nullable();
            $table->string('added_windows_login_name',100)->collation('utf8_general_ci')->nullable();
            $table->string('update_windows_login_name',100)->collation('utf8_general_ci')->nullable();
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
        Schema::dropIfExists('con_reason_masters');
    }
}
