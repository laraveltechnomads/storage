<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateExpenseDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('expense_details', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('expense_id')->nullable();
            $table->foreign('expense_id')->references('id')->on('expense_masters')->onDelete('cascade');
            $table->unsignedBigInteger('unit_id')->nullable();
            $table->foreign('unit_id')->references('id')->on('units')->onDelete('cascade');
            $table->string('voucher_no',20)->nullable();
            $table->date('voucher_date')->nullable();
            $table->float('amount')->nullable();
            $table->text('remark')->nullable();
            $table->integer('freeze')->nullable();
            $table->integer('status')->comment('1:Active,0:Inactive')->nullable();
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
        Schema::dropIfExists('expense_details');
    }
}
