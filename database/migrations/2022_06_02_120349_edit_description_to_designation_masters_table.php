<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class EditDescriptionToDesignationMastersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {        
        Schema::table('item_margin_masters', function (Blueprint $table) {
            $table->string('description')->nullable()->change();
        });
        Schema::table('designation_masters', function (Blueprint $table) {
            $table->string('description')->nullable()->change();
        });
        Schema::table('primary_symptoms', function (Blueprint $table) {
            $table->string('description')->nullable()->change();
        });
        Schema::table('bank_masters', function (Blueprint $table) {
            $table->string('description')->nullable()->change();
        });
        Schema::table('bank_branch_masters', function (Blueprint $table) {
            $table->string('description')->nullable()->change();
        });
        Schema::table('emr_field_values', function (Blueprint $table) {
            $table->string('description')->nullable()->change();
        });
        Schema::table('emr_chief_complaints', function (Blueprint $table) {
            $table->string('description')->nullable()->change();
        });
        Schema::table('ot_masters', function (Blueprint $table) {
            $table->string('description')->nullable()->change();
        });
        Schema::table('procedure_type_masters', function (Blueprint $table) {
            $table->string('description')->nullable()->change();
        });
        Schema::table('operation_result_masters', function (Blueprint $table) {
            $table->string('description')->nullable()->change();
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        /*
        -item_margin_masters
        -designation_masters
        -primary_symptoms
        -bank_masters
        -bank_branch_masters
        -emr_field_values
        -emr_chief_complaints
        -ot_masters
        -procedure_type_masters
        -operation_result_masters
        */
        Schema::table('item_margin_masters', function (Blueprint $table) {
            $table->string('description', 10)->nullable()->change();
        });
        Schema::table('designation_masters', function (Blueprint $table) {
            $table->string('description', 10)->nullable()->change();
        });
        Schema::table('primary_symptoms', function (Blueprint $table) {
            $table->string('description', 10)->nullable()->change();
        });
        Schema::table('bank_masters', function (Blueprint $table) {
            $table->string('description', 10)->nullable()->change();
        });
        Schema::table('bank_branch_masters', function (Blueprint $table) {
            $table->string('description', 10)->nullable()->change();
        });
        Schema::table('emr_field_values', function (Blueprint $table) {
            $table->string('description', 10)->nullable()->change();
        });
        Schema::table('emr_chief_complaints', function (Blueprint $table) {
            $table->string('description', 10)->nullable()->change();
        });
        Schema::table('ot_masters', function (Blueprint $table) {
            $table->string('description', 10)->nullable()->change();
        });
        Schema::table('procedure_type_masters', function (Blueprint $table) {
            $table->string('description', 10)->nullable()->change();
        });
        Schema::table('operation_result_masters', function (Blueprint $table) {
            $table->string('description', 10)->nullable()->change();
        });
        Schema::table('operation_result_masters', function (Blueprint $table) {
            $table->string('description', 10)->nullable()->change();
        });
    }
}