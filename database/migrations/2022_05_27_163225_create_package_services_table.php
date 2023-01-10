<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePackageServicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('package_services', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('package_id')->nullable();
            $table->unsignedBigInteger('service_id')->nullable();
            $table->integer('qty')->nullable();
            $table->string('applicable',50)->nullable();
            $table->tinyInteger('consumable')->default(0)->comment('1:check,0:Uncheck');
            $table->tinyInteger('adjustable_head')->default(0)->comment('1:check,0:Uncheck');
            $table->string('process_name',50)->nullable();
            $table->string('adjusted_against',50)->nullable();
            $table->string('rate_limit',10)->nullable();
            $table->foreign('package_id')->references('id')->on('packages')->onDelete('cascade');
            $table->foreign('service_id')->references('id')->on('service_masters')->onDelete('cascade');
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
        Schema::dropIfExists('package_services');
    }
}
