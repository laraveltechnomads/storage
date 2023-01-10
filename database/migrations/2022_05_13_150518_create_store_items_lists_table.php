<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateStoreItemsListsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('store_items_lists', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('item_id')->nullable();
            $table->string('item_name')->nullable();
            $table->string('barcode', 50)->nullable();
            $table->string('batch_code', 50)->nullable();
            $table->date('exp_delivery_date')->nullable();
            $table->integer('indent_qty')->nullable();
            $table->integer('received_qty')->nullable();
            $table->integer('pending_qty')->nullable();
            $table->string('purchase_uom')->nullable();
            $table->decimal('rate', 8, 2)->nullable();
            $table->decimal('avg_cost', 8, 2)->nullable();
            $table->decimal('avg_cost_amount', 8, 2)->nullable();
            $table->decimal('net_amount', 8, 2)->nullable();
            $table->decimal('base_cost_price', 8, 2)->nullable();
            $table->decimal('total_cost_price', 8, 2)->nullable();
            $table->unsignedBigInteger('unit_id')->index();
            $table->unsignedBigInteger('store_id')->index();
            $table->tinyInteger('status')->default(1)->comment('1=new, 2=completed, 3=pending');
            $table->unsignedBigInteger('created_unit_id')->nullable();
            $table->unsignedBigInteger('updated_unit_id')->nullable();
            $table->string('added_by',50)->nullable();
            $table->string('added_on',50)->nullable();
            $table->string('added_date_time',50)->nullable();
            $table->string('added_utc_date_time',50)->nullable();
            $table->string('added_windows_login_name',50)->nullable();
            $table->string('updated_by',50)->nullable();
            $table->string('updated_on',50)->nullable();
            $table->string('updated_date_time',50)->nullable();
            $table->string('updated_utc_date_time',50)->nullable();
            $table->string('update_windows_login_name',50)->nullable();
            $table->string('synchronized',50)->nullable();
            $table->timestamp('created_at')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->timestamp('updated_at')->nullable()->default(DB::raw('CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP'));
            $table->foreign('item_id')->references('id')->on('items');
            $table->foreign('store_id')->references('id')->on('stores');
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
        Schema::dropIfExists('store_items_lists');
    }
}
