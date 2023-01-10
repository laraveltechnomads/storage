<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateItemClinicsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('item_clinics', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('store_id')->nullable();
            $table->unsignedBigInteger('item_id')->nullable();
            $table->unsignedBigInteger('unit_id')->nullable();
            $table->bigInteger('min');
            $table->bigInteger('max');
            $table->integer('re_order')->comment('1:yes,0:no')->default(0)->nullable();
            $table->integer('status')->comment('1:Active,0:Inactive')->default(1)->nullable();
            $table->integer('is_item_block')->comment('0:not, 1:block')->default(0)->nullable();
            $table->string('created_unit_id',16)->collation('utf8_general_ci')->nullable();
            $table->string('updated_unit_id',16)->collation('utf8_general_ci')->nullable();
            $table->string('added_by',100)->collation('utf8_general_ci')->nullable();
            $table->string('added_on',100)->collation('utf8_general_ci')->nullable();
            $table->string('added_date_time',100)->collation('utf8_general_ci')->nullable();
            $table->string('added_utc_date_time',100)->collation('utf8_general_ci')->nullable();
            $table->string('updated_by',100)->collation('utf8_general_ci')->nullable();
            $table->string('updated_on',100)->collation('utf8_general_ci')->nullable();
            $table->string('updated_date_time',100)->collation('utf8_general_ci')->nullable();
            $table->string('added_windows_login_name',100)->collation('utf8_general_ci')->nullable();
            $table->string('update_windows_login_name',100)->collation('utf8_general_ci')->nullable();
            $table->integer('synchronized')->nullable();
            $table->timestamps();

            $table->foreign('store_id')->references('id')->on('stores')->onDelete('cascade');
            $table->foreign('item_id')->references('id')->on('items')->onDelete('cascade');
            $table->foreign('unit_id')->references('id')->on('units')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('item_clinics');
    }
}
