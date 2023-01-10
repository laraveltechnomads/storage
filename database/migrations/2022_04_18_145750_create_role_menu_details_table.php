<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRoleMenuDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('role_menu_details', function (Blueprint $table) {
            $table->id();
            $table->integer('unit_id')->nullable();
            $table->integer('role_id')->nullable();
            $table->integer('menu_id')->nullable();
            $table->integer('submenu_id')->nullable();
            $table->integer('status')->nullable();
            $table->integer('is_create')->nullable();
            $table->integer('is_update')->nullable();
            $table->integer('is_all')->nullable();
            $table->integer('is_read')->nullable();
            $table->integer('is_print')->nullable();
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
        Schema::dropIfExists('role_menu_details');
    }
}
