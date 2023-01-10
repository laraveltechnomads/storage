<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateTreatmentRequiredMastersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('treatment_required_masters', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('unit_id')->nullable();
            $table->string('code',100)->nullable();
            $table->string('description', 100)->nullable();
            $table->tinyInteger('status')->default(1)->comment('1:Active, 0:InActive');
            
            $table->unsignedBigInteger('created_unit_id')->nullable();
            $table->unsignedBigInteger('updated_unit_id')->nullable();
            $table->integer('added_by')->nullable();
            $table->string('added_on',100)->nullable();
            $table->timestamp('added_date_time')->nullable();
            $table->string('updated_by',100)->nullable();
            $table->string('updated_on',100)->nullable();
            $table->timestamp('updated_date_time')->nullable();
            $table->string('added_windows_login_name',100)->nullable();
            $table->string('update_windows_login_name',100)->nullable();
            $table->integer('synchronized')->nullable();

            $table->foreign('unit_id')->references('id')->on('units');
            $table->foreign('created_unit_id')->references('id')->on('units');
            $table->foreign('updated_unit_id')->references('id')->on('units');


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
        Schema::dropIfExists('treatment_required_masters');
    }
}
