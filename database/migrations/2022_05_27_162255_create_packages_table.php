<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePackagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('packages', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('s_id')->nullable();
            $table->unsignedBigInteger('ss_id')->nullable();
            $table->string('code',50)->nullable();
            $table->string('package_name')->nullable();
            $table->string('sac_code',50)->nullable();
            $table->double('rate')->nullable();
            $table->string('duration',50)->nullable();
            $table->string('service_component',50)->nullable();
            $table->string('pharmacy_component',50)->nullable();
            $table->string('distribution_in',50)->nullable();
            $table->text('item_list')->nullable();
            $table->text('item_category_list')->nullable();
            $table->text('item_group_list')->nullable();
            $table->double('total_amt')->nullable();
            $table->double('remain_amt')->nullable();
            $table->double('use_amt')->nullable();
            $table->tinyInteger('set_all_items')->default(0)->comment('1:Check,0:Uncheck');
            $table->tinyInteger('is_enable')->default(1)->comment('1:Enable,0:Desable');
            $table->tinyInteger('status')->default(1)->comment('1:Active,0:Inactive');
            $table->foreign('s_id')->references('id')->on('specializations')->onDelete('cascade');
            $table->foreign('ss_id')->references('id')->on('sub_specializations')->onDelete('cascade');
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
        Schema::dropIfExists('packages');
    }
}
