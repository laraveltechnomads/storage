<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('items', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('unit_id')->nullable();
            $table->smallInteger('item_code')->nullable();
            $table->string('brand_name', 24)->nullable();
            $table->string('strength', 10)->nullable();
            $table->string('item_name', 25)->nullable();
            $table->tinyInteger('molecule_name')->nullable();
            $table->tinyInteger('item_group')->nullable();
            $table->tinyInteger('item_category')->nullable();
            $table->tinyInteger('dispensing_type')->nullable();
            $table->tinyInteger('storage_type')->nullable();
            $table->decimal('storage_degree',4, 3)->nullable();
            $table->tinyInteger('preg_class')->nullable();
            $table->tinyInteger('ther_class')->nullable();
            $table->tinyInteger('mfg_by')->nullable();
            $table->tinyInteger('mrk_by')->nullable();
            $table->tinyInteger('PUM')->nullable();
            $table->tinyInteger('SUM')->nullable();
            $table->tinyInteger('conversion_factor')->nullable();
            $table->tinyInteger('route')->nullable();
            $table->decimal('purchase_rate', 3, 2)->nullable();
            $table->decimal('MRP', 3, 2)->nullable();
            $table->decimal('vat_per', 3, 2)->nullable();
            $table->tinyInteger('reorder_qnt')->nullable();
            $table->tinyInteger('batches_required')->nullable();
            $table->tinyInteger('inclusive_of_tax')->nullable();
            $table->decimal('discount_on_sale', 2, 1)->nullable();
            $table->unsignedBigInteger('item_margin_id')->nullable();
            $table->unsignedBigInteger('item_movement_id')->nullable();
            $table->tinyInteger('margin')->nullable();
            $table->decimal('highest_retail_price', 4, 3)->nullable();
            $table->decimal('min_stock', 4, 3)->nullable();
            $table->tinyInteger('status')->nullable();
            $table->unsignedBigInteger('created_unit_id')->nullable();
            $table->unsignedBigInteger('updated_unit_id')->nullable();
            $table->tinyInteger('added_by')->nullable();
            $table->string('added_on', 15)->nullable();
            $table->string('added_date_time', 19)->nullable();
            $table->string('updated_by', 10)->nullable();
            $table->string('updated_on', 10)->nullable();
            $table->timestamp('updated_date_time')->nullable();
            $table->string('added_windows_login_name', 12)->nullable();
            $table->string('update_windows_login_name', 10)->nullable();
            $table->tinyInteger('synchronized')->nullable();
            $table->string('barcode', 50)->nullable();
            $table->tinyInteger('is_ABC')->nullable();
            $table->tinyInteger('is_FNS')->nullable();
            $table->tinyInteger('is_VED')->nullable();
            $table->tinyInteger('strength_unit_type_id')->nullable();
            $table->tinyInteger('base_um')->nullable();
            $table->tinyInteger('selling_um')->nullable();
            $table->tinyInteger('conv_fact_stock_base')->nullable();
            $table->tinyInteger('conv_fact_base_sale')->nullable();
            $table->tinyInteger('item_expired_in_days')->nullable();
            $table->tinyInteger('hsn_codes_id')->nullable();
//
            $table->unsignedBigInteger('molecule_id')->nullable();
            $table->unsignedBigInteger('item_group_id')->nullable();
            $table->unsignedBigInteger('item_category_id')->nullable();
//
            $table->foreign('unit_id')->references('id')->on('units');
            $table->foreign('item_margin_id')->references('id')->on('item_margin_masters');
            $table->foreign('item_movement_id')->references('id')->on('item_movement_masters');
            $table->foreign('molecule_id')->references('id')->on('molecules');
            $table->foreign('item_group_id')->references('id')->on('item_groups');
            $table->foreign('item_category_id')->references('id')->on('item_categories');

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
        Schema::dropIfExists('items');
    }
}
