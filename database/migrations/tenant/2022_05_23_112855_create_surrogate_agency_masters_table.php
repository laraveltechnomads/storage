<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSurrogateAgencyMastersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('surrogate_agency_masters', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('unit_id')->nullable();
            $table->string('code',100)->nullable();
            $table->string('description', 100)->nullable();
            
            $table->string('referral_name', 100)->nullable();
            $table->string('email_address', 90)->nullable();
            $table->string('contact_no', 16)->nullable();
            $table->string('affiliated_by', 90)->nullable();
            $table->string('affiliated_year', 90)->nullable();
            $table->string('registration_no',100)->nullable();
            $table->text('address')->nullable();
            
            $table->tinyInteger('status')->default(1)->comment('1:Active, 0:InActive');
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

            $table->foreign('unit_id')->references('id')->on('units');
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
        Schema::dropIfExists('surrogate_agency_masters');
    }
}
