<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWardMastersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ward_masters', function (Blueprint $table) {
            $table->id();
            $table->string('code',20)->nullable();
            $table->string('description')->collation('utf8_general_ci')->nullable();
            $table->unsignedBigInteger('unit_id')->nullable();
            $table->unsignedBigInteger('block_id')->nullable();
            $table->unsignedBigInteger('floor_id')->nullable();
            $table->unsignedBigInteger('ward_type_id')->nullable();
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
            $table->foreign('unit_id')->references('id')->on('units');
            $table->foreign('block_id')->references('id')->on('block_masters');
            $table->foreign('floor_id')->references('id')->on('floor_masters');
            $table->foreign('ward_type_id')->references('id')->on('ward_types');
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
        Schema::dropIfExists('ward_masters');
    }
}
