<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateMedicineBillsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('medicine_bills', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('item_id');
            $table->unsignedBigInteger('patient_medicine_id')->nullable();
            $table->integer('qty');
            $table->double('mrp')->default('0.00');
            $table->double('total_amount')->default('0.00');
            $table->double('concession')->default('0.00');
            $table->double('sgst')->default('0.00');
            $table->double('cgst')->default('0.00');
            $table->double('net_amount')->default('0.00');
            $table->unsignedBigInteger('doc_id')->nullable();
            $table->unsignedBigInteger('patient_id')->nullable();
            $table->unsignedBigInteger('unit_id')->nullable();
            $table->boolean('is_ipd')->default(0);
            $table->boolean('is_opd')->default(0);
            $table->date('date')->nullable();
            $table->tinyInteger('status')->default(1)->comment('1= active, 0=inactive');

            $table->unsignedBigInteger('created_unit_id')->nullable();
            $table->unsignedBigInteger('updated_unit_id')->nullable();
            $table->string('added_by')->nullable();
            $table->string('added_on')->nullable();
            $table->timestamp('added_date_time')->nullable();
            $table->timestamp('added_utc_date_time')->nullable();
            $table->string('added_windows_login_name')->nullable();
            $table->string('updated_by')->nullable();
            $table->string('updated_on')->nullable();
            $table->timestamp('updated_date_time')->nullable();
            $table->timestamp('updated_utc_date_time')->nullable();
            $table->string('updated_windows_login_name')->nullable();
            $table->tinyInteger('synchronized')->default(0)->comment('1= active, 0=inactive');
            $table->timestamp('created_at')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->timestamp('updated_at')->nullable()->default(DB::raw('CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP'));

            $table->foreign('item_id')->references('id')->on('items');
            $table->foreign('patient_medicine_id')->references('id')->on('patient_medicines');
            $table->foreign('doc_id')->references('id')->on('doctors');
            $table->foreign('patient_id')->references('id')->on('registrations');
            $table->foreign('unit_id')->references('id')->on('units');
            $table->foreign('created_unit_id')->references('id')->on('units');
            $table->foreign('updated_unit_id')->references('id')->on('units');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('medicine_bills');
    }
}
