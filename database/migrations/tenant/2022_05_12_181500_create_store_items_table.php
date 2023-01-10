<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateStoreItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('store_items', function (Blueprint $table) {
            $table->id();
            $table->string('store_no')->unique()->collation('utf8_general_ci')->nullable();
            $table->date('store_date')->nullable();
            $table->date('exp_delivery_date')->nullable();
            $table->unsignedBigInteger('store_item_type_id')->nullable();
            $table->unsignedBigInteger('from_store_id')->nullable();
            $table->unsignedBigInteger('to_store_id')->nullable();
            $table->unsignedBigInteger('patient_id')->nullable();
            $table->string('item_ids')->collation('utf8_general_ci')->nullable();
            $table->unsignedBigInteger('unit_id')->index();
            $table->tinyInteger('status')->default(1)->comment('1=new, 2=completed, 3=pending');
            $table->boolean('freezed')->default(0);
            $table->boolean('approved')->default(0);
            $table->timestamp('created_at')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->timestamp('updated_at')->nullable()->default(DB::raw('CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP'));
            $table->softDeletes();
            $table->float('amount', 8, 2)->default(0)->nullable()->change();
            $table->text('reason')->nullable()->collation('utf8_general_ci');
            $table->text('remark')->nullable()->collation('utf8_general_ci');
            $table->foreign('store_item_type_id')->references('id')->on('store_item_types');
            $table->foreign('from_store_id')->references('id')->on('stores');
            $table->foreign('to_store_id')->references('id')->on('stores');
            $table->foreign('patient_id')->references('id')->on('registrations');
            $table->foreign('unit_id')->references('id')->on('units');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('store_items');
    }
}
