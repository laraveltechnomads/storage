<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStoresTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('stores', function (Blueprint $table) {
            $table->id();
            $table->string('description',100)->nullable();
            $table->string('code',100)->nullable();
            $table->string('clinic_id',100)->nullable();
            $table->string('cost_center_code',100)->nullable();
            $table->string('opening_balance',100)->nullable();
            $table->string('indent',100)->nullable();
            $table->string('issue',100)->nullable();
            $table->string('item_return',100)->nullable();
            $table->string('goods_received_note',100)->nullable();
            $table->string('grn_return',100)->nullable();
            $table->string('items_sale',100)->nullable();
            $table->string('items_sale_return',100)->nullable();
            $table->string('expiry_item_return',100)->nullable();
            $table->string('receive_issue',100)->nullable();
            $table->string('receive_issue_return',100)->nullable();
            $table->string('isparent',100)->nullable();
            $table->string('status',100)->comment('1:Active,0:Inactive')->nullable();
            $table->string('is_central_store',100)->nullable();
            $table->string('created_unit_id',100)->nullable();
            $table->string('updated_unit_id',100)->nullable();
            $table->string('added_by',100)->nullable();
            $table->string('added_on',100)->nullable();
            $table->string('added_date_time',100)->nullable();
            $table->string('updated_by',100)->nullable();
            $table->string('updated_on',100)->nullable();
            $table->string('updated_date_time',100)->nullable();
            $table->string('added_windows_login_name',100)->nullable();
            $table->string('update_windows_login_name',100)->nullable();
            $table->string('synchronized',100)->nullable();
            $table->string('is_quarantine_store',100)->nullable();
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
        Schema::dropIfExists('stores');
    }
}
