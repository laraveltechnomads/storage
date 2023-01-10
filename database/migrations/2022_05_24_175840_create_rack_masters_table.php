<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRackMastersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rack_masters', function (Blueprint $table) {
            $table->id();
            $table->string('rack_code',50)->nullable();
            $table->string('description')->nullable();
            $table->tinyInteger('status')->comment('1:Active,0:Inactive')->default(1);
            $table->unsignedBigInteger('created_unit_id')->nullable();
            $table->unsignedBigInteger('updated_unit_id')->nullable();
            $table->string('added_by',10)->nullable();
            $table->string('added_on',10)->nullable();
            $table->timestamp('added_date_time')->nullable();
            $table->timestamp('added_utc_date_time')->nullable();
            $table->string('updated_by', 10)->nullable();
            $table->string('updated_on', 10)->nullable();
            $table->timestamp('updated_date_time')->nullable();
            $table->timestamp('updated_utc_date_time')->nullable();
            $table->string('added_windows_login_name', 12)->nullable();
            $table->string('update_windows_login_name', 10)->nullable();
            $table->tinyInteger('synchronized')->nullable();
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
        Schema::dropIfExists('rack_masters');
    }
}
