<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class EditDeptCodeToDepartmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('departments', function (Blueprint $table) {
            
            if (Schema::hasColumn('departments', 'dept_code')){
                $table->dropColumn('dept_code');
            }
            if (!Schema::hasColumn('departments', 'code')){
                $table->string('code')->nullable()->after('id');
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
        Schema::table('departments', function (Blueprint $table) {
            if (!Schema::hasColumn('departments', 'dept_code')){
                $table->string('dept_code')->nullable()->after('id');
                
            }
            if (Schema::hasColumn('departments', 'code')){
                $table->dropColumn('code');
            }   
        });
    }
}
