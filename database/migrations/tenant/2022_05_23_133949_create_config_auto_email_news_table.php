<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateConfigAutoEmailNewsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('config_auto_email_news', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('ce_sms_event_type_id')->nullable();
            $table->unsignedBigInteger('email_template_id')->nullable();
            $table->unsignedBigInteger('sms_template_id')->nullable();
            $table->string('email_id',100)->nullable();
            $table->tinyInteger('status')->default(1)->comment('1:Active,0:Inactive');
            $table->unsignedBigInteger('created_unit_id')->nullable();
            $table->unsignedBigInteger('updated_unit_id')->nullable();
            $table->string('added_by',50)->nullable();
            $table->string('added_on',50)->nullable();
            $table->timestamp('added_date_time')->nullable();
            $table->timestamp('added_utc_date_time')->nullable();
            $table->string('updated_by',50)->nullable();
            $table->timestamp('updated_date_time')->nullable();
            $table->timestamp('updated_utc_date_time')->nullable();
            $table->string('added_windows_login_name',50)->nullable();
            $table->string('update_windows_login_name',50)->nullable();
            $table->integer('synchronized')->nullable();
            $table->unsignedBigInteger('app_config_id')->nullable();
            $table->unsignedBigInteger('unit_id')->nullable();
            $table->foreign('ce_sms_event_type_id')->references('id')->on('config_email_sms_event_types')->onDelete('cascade');
            $table->foreign('email_template_id')->references('id')->on('email_templates')->onDelete('cascade');
            $table->foreign('sms_template_id')->references('id')->on('sms_templates')->onDelete('cascade');
            $table->foreign('created_unit_id')->references('id')->on('units')->onDelete('cascade');
            $table->foreign('updated_unit_id')->references('id')->on('units')->onDelete('cascade');
            $table->foreign('app_config_id')->references('id')->on('config_applications')->onDelete('cascade');
            $table->foreign('unit_id')->references('id')->on('units')->onDelete('cascade');
            $table->timestamps();
        });
        if (!Schema::hasColumn('company_masters', 'title')) {
            Schema::table('company_masters', function (Blueprint $table) {
                $table->text('title')->nullable()->after('description');
            });
        }
        if (!Schema::hasColumn('mode_of_payments', 'json_text')) {
            Schema::table('mode_of_payments', function (Blueprint $table) {
                $table->text('json_text')->nullable()->after('description');
            }); 
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('config_auto_email_news');
        if (Schema::hasColumn('company_masters', 'title')) {
            Schema::table('company_masters', function (Blueprint $table) {
                $table->dropColumn(['title']);
            });
        };
        if (Schema::hasColumn('mode_of_payments', 'json_text')) {
            Schema::table('mode_of_payments', function (Blueprint $table) {
                $table->dropColumn(['json_text']);
            });
        };
    }
}
