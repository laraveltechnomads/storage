<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateClientsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('clients', function (Blueprint $table) {
            $table->id();
            $table->string('fname', 45)->nullable();
            $table->string('lname', 45)->nullable();
            $table->string('email_address', 90)->unique()->nullable();
            $table->string('password')->nullable();
            $table->string('sub_domain')->unique()->nullable();
            $table->string('db_name')->unique()->nullable();
            $table->string('clinic')->nullable()->nullable();
            $table->string('contact_no', 16)->nullable();
            $table->enum('type', ['0', '1', '2', '3'])->default(0)->comment('0= demo, 1 = single clinic, 2 = more clinics, 3 = corporate');
            $table->string('identity',255)->nullable();
            $table->string('bussiness',255)->nullable();
            $table->string('terms')->nullable();
            $table->string('plan_status')->nullable();
            $table->tinyInteger('status')->default(1)->comment('1= active, 0=inactive');
            $table->rememberToken()->nullable();
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
        Schema::dropIfExists('clients');
    }
}
