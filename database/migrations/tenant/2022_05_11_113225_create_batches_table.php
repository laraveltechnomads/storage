<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBatchesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('batches', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('unit_id')->nullable();
            $table->foreign('unit_id')->references('id')->on('units')->onDelete('cascade');
            $table->date('date')->nullable();
            $table->time('time')->nullable();
            $table->unsignedBigInteger('item_id')->nullable();
            $table->foreign('item_id')->references('id')->on('items')->onDelete('cascade');
            $table->string('batch_code',100)->unique()->nullable();
            $table->date('expiry_date')->nullable();
            $table->integer('qty')->nullable();
            $table->string('conversion_factor')->nullable();
            $table->string('purchase_rate')->nullable();
            $table->double('mrp')->nullable();
            $table->string('stocking_purchase_rate')->nullable();
            $table->double('stocking_mrp')->nullable();
            $table->float('vat_percentage')->nullable();
            $table->double('vat_amount')->nullable();
            $table->double('discount_on_sale')->nullable();
            $table->string('remarks')->nullable();
            $table->string('landedRate')->nullable();
            $table->string('barcode')->nullable();
            $table->integer('is_consignment')->comment('0:no, 1:yes')->default(0)->nullable();
            $table->integer('is_free')->comment('0:no, 1:yes')->default(0)->nullable();
            $table->integer('status')->comment('1:Active,0:Inactive')->default(1)->nullable();
            $table->string('created_unit_id',16)->collation('utf8_general_ci')->nullable();
            $table->string('updated_unit_id',16)->collation('utf8_general_ci')->nullable();
            $table->string('added_by',100)->collation('utf8_general_ci')->nullable();
            $table->string('added_on',100)->collation('utf8_general_ci')->nullable();
            $table->string('added_date_time',100)->collation('utf8_general_ci')->nullable();
            $table->string('updated_by',100)->collation('utf8_general_ci')->nullable();
            $table->string('updated_on',100)->collation('utf8_general_ci')->nullable();
            $table->string('updated_date_time',100)->collation('utf8_general_ci')->nullable();
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
        Schema::dropIfExists('batches');
    }
}
