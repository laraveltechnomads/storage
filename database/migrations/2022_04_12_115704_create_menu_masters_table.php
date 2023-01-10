<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateMenuMastersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('menu_masters', function (Blueprint $table) {
            $table->id();
            $table->integer('menu_id')->nullable();
            $table->string('title',255)->nullable();
            $table->string('sub_title',255)->nullable();
            $table->string('image_path',255)->nullable();
            $table->integer('parent_id')->nullable();
            $table->integer('module_id')->nullable();
            $table->integer('menu_order')->nullable();
            $table->tinyInteger('status')->default(1)->comment('1= active, 0=inactive');
            $table->text('path')->nullable();
            $table->tinyInteger('menu_for')->default(1);
            $table->unsignedBigInteger('created_unit_id')->nullable();
            $table->unsignedBigInteger('updated_unit_id')->nullable();
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
        Schema::dropIfExists('menu_masters');
    }
}
