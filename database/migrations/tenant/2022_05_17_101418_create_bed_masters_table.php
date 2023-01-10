<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBedMastersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bed_masters', function (Blueprint $table) {
            $table->id();
            $table->string('code',20)->nullable();
            $table->string('description')->collation('utf8_general_ci')->nullable();
            $table->tinyInteger('is_non_consus')->comment('1:Check,0:Uncheck')->nullable();
            $table->text('bed_amenity_ids')->collation('utf8_general_ci')->nullable();
            $table->unsignedBigInteger('unit_id')->nullable();
            $table->unsignedBigInteger('ward_id')->nullable();
            $table->unsignedBigInteger('room_id')->nullable();
            $table->unsignedBigInteger('bed_class_id')->nullable();
            $table->tinyInteger('status')->default(1)->comment('1:Active,0:Inactive');
            $table->unsignedBigInteger('created_unit_id')->nullable();
            $table->unsignedBigInteger('updated_unit_id')->nullable();
            $table->string('added_by',50)->collation('utf8_general_ci')->nullable();
            $table->string('added_on',50)->collation('utf8_general_ci')->nullable();
            $table->timestamp('added_date_time')->nullable();
            $table->timestamp('added_utc_date_time')->nullable();
            $table->string('updated_by',50)->collation('utf8_general_ci')->nullable();
            $table->timestamp('updated_date_time')->nullable();
            $table->timestamp('updated_utc_date_time')->nullable();
            $table->string('added_windows_login_name',50)->collation('utf8_general_ci')->nullable();
            $table->string('update_windows_login_name',50)->collation('utf8_general_ci')->nullable();
            $table->string('synchronized',50)->collation('utf8_general_ci')->nullable();
            $table->foreign('unit_id')->references('id')->on('units');
            $table->foreign('ward_id')->references('id')->on('ward_masters');
            $table->foreign('room_id')->references('id')->on('room_masters');
            $table->foreign('bed_class_id')->references('id')->on('class_masters');
            $table->foreign('created_unit_id')->references('id')->on('units');
            $table->foreign('updated_unit_id')->references('id')->on('units');
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
        Schema::dropIfExists('bed_masters');
    }
}
