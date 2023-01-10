<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStorageTypesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('storage_types', function (Blueprint $table) {
            $table->id();
            $table->tinyInteger('code')->nullable();
            $table->string('description', 50)->nullable();
            $table->tinyInteger('status')->nullable();
            $table->unsignedBigInteger('created_unit_id')->nullable();
            $table->unsignedBigInteger('updated_unit_id')->nullable();
            $table->tinyInteger('added_by')->nullable();
            $table->string('added_on', 10)->nullable();
            $table->timestamp('added_date_time')->nullable();
            $table->string('updated_by', 10)->nullable();
            $table->string('updated_on', 10)->nullable();
            $table->timestamp('updated_date_time')->nullable();
            $table->string('added_windows_login_name', 12)->nullable();
            $table->string('update_windows_login_name', 10)->nullable();
            $table->tinyInteger('synchronized')->nullable();
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
        Schema::dropIfExists('storage_types');
    }
}
