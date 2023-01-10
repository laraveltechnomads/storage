<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateConfigEmailSmsEventTypesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('config_email_sms_event_types', function (Blueprint $table) {
            $table->id();
            $table->string('ce_sms_event_type_code',20)->nullable();
            $table->string('description',100)->nullable();
            $table->tinyInteger('status')->comment('1:Active,0:Inactive')->nullable();
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
        Schema::dropIfExists('config_email_sms_event_types');
    }
}
