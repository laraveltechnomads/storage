<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateExpenseMastersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('expense_masters', function (Blueprint $table) {
            $table->id();
            $table->string('expens_code',20)->nullable();
            $table->string('description',200)->nullable();
            $table->integer('status')->comment('1:Active,0:Inactive')->nullable();
            $table->string('created_unit_id',20)->nullable();
            $table->string('updated_unit_id',20)->nullable();
            $table->string('added_by',20)->nullable();
            $table->string('added_on',20)->nullable();
            $table->string('added_date_time',20)->nullable();
            $table->string('added_utc_date_time',20)->nullable();
            $table->string('updated_by',20)->nullable();
            $table->string('updated_date_time',20)->nullable();
            $table->string('updated_utc_date_time',20)->nullable();
            $table->string('added_windows_login_name',20)->nullable();
            $table->string('update_windows_login_name',20)->nullable();
            $table->string('synchronized',20)->nullable();
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
        Schema::dropIfExists('expense_masters');
    }
}
