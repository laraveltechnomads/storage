<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddEditTextFieldToSmsTemplatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('sms_templates', function (Blueprint $table) {
            if (!Schema::hasColumn('sms_templates', 'text')) {
                $table->text('text')->nullable()->after('subject');
            }
        });
        Schema::table('email_templates', function (Blueprint $table) {
            if (!Schema::hasColumn('email_templates', 'text')) {
                $table->text('text')->nullable()->after('subject');
            }
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('sms_templates', function (Blueprint $table) {
            if (Schema::hasColumn('sms_templates', 'text')) {
                $table->dropColumn('text');
            }
        });
        Schema::table('email_templates', function (Blueprint $table) {
            if (Schema::hasColumn('email_templates', 'text')) {
                $table->dropColumn('text');
            }
        });
    }
}
