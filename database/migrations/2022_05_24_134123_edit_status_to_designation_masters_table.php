<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class EditStatusToDesignationMastersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        
        Schema::table('designation_masters', function (Blueprint $table) {
            $table->boolean('status')->default(1)->comment('1=active, 0=inactive')->change();
        });

        Schema::table('primary_symptoms', function (Blueprint $table) {
            $table->boolean('status')->default(1)->comment('1=active, 0=inactive')->change();
        });

        Schema::table('bank_masters', function (Blueprint $table) {
            $table->boolean('status')->default(1)->comment('1=active, 0=inactive')->change();
        });

        Schema::table('bank_branch_masters', function (Blueprint $table) {
            $table->boolean('status')->default(1)->comment('1=active, 0=inactive')->change();
        });
        
        Schema::table('region_masters', function (Blueprint $table) {
            $table->boolean('status')->default(1)->comment('1=active, 0=inactive')->after('created_at');
        });

        Schema::table('adhesions', function (Blueprint $table) {
            $table->boolean('status')->default(1)->comment('1=active, 0=inactive')->change();
        });

        Schema::table('emr_field_values', function (Blueprint $table) {
            $table->boolean('status')->default(1)->comment('1=active, 0=inactive')->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('designation_masters', function (Blueprint $table) {
            $table->string('status', 10)->nullable()->change();
        });
        Schema::table('primary_symptoms', function (Blueprint $table) {
            $table->string('status', 10)->nullable()->change();
        });
        Schema::table('bank_masters', function (Blueprint $table) {
            $table->string('status', 10)->nullable()->change();
        });
        Schema::table('bank_branch_masters', function (Blueprint $table) {
            $table->string('status', 10)->nullable()->change();
        });
        Schema::table('region_masters', function (Blueprint $table) {
            $table->dropColumn('status');
        });
        Schema::table('adhesions', function (Blueprint $table) {
            $table->string('status', 10)->nullable()->change();
        });
        Schema::table('emr_field_values', function (Blueprint $table) {
            $table->string('status', 10)->nullable()->change();
        });
    }
}
