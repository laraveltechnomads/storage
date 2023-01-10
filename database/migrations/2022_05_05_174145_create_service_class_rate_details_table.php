<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateServiceClassRateDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('service_class_rate_details', function (Blueprint $table) {
            $table->id();
            $table->string('aclass_id_unit_id',16)->collation('utf8_general_ci')->nullable();
            $table->text('ser_id')->collation('utf8_general_ci')->nullable();
            $table->string('class_id',16)->collation('utf8_general_ci')->nullable();
            $table->string('class_unit_id',16)->collation('utf8_general_ci')->nullable();
            $table->float('rate', 8, 2)->nullable();
            $table->integer('status')->comment('1:Active,0:Inactive')->nullable();
            $table->string('created_unit_id',16)->collation('utf8_general_ci')->nullable();
            $table->string('updated_unit_id',16)->collation('utf8_general_ci')->nullable();
            $table->string('added_by',50)->collation('utf8_general_ci')->nullable();
            $table->string('added_on',50)->collation('utf8_general_ci')->nullable();
            $table->string('added_date_time',50)->collation('utf8_general_ci')->nullable();
            $table->string('added_utc_date_time',50)->collation('utf8_general_ci')->nullable();
            $table->string('updated_by',50)->collation('utf8_general_ci')->nullable();
            $table->string('updated_on',50)->collation('utf8_general_ci')->nullable();
            $table->string('updated_date_time',50)->collation('utf8_general_ci')->nullable();
            $table->string('updated_utc_date_time',50)->collation('utf8_general_ci')->nullable();
            $table->string('added_windows_login_name',50)->collation('utf8_general_ci')->nullable();
            $table->string('update_windows_login_name',50)->collation('utf8_general_ci')->nullable();
            $table->string('synchronized',5)->collation('utf8_general_ci')->nullable();
            $table->unsignedBigInteger('doc_cat_id')->nullable();
            $table->foreign('doc_cat_id')->references('id')->on('doctor_categories')->onDelete('cascade');
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
        Schema::disableForeignKeyConstraints();
        Schema::dropIfExists('service_class_rate_details');
    }
}
