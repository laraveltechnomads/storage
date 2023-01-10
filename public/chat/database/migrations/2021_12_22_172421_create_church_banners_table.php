<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateChurchBannersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('church_banners', function (Blueprint $table) {
            $table->id();
            $table->string('banner_image')->nullable();
            $table->unsignedBigInteger('church_id')->nullable();
            $table->integer('serial_number')->nullable();
            $table->tinyInteger('is_active')->default(1)->nullable()->comment('0: Not Active, 1: Active');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('church_banners');
    }
}
