<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateDischargeDestinationMastersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('discharge_destination_masters', function (Blueprint $table) {
            $table->id();
            $table->string('code',20)->nullable();
            $table->string('description')->collation('utf8_general_ci')->nullable();
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
            $table->foreign('created_unit_id')->references('id')->on('units');
            $table->foreign('updated_unit_id')->references('id')->on('units');
            $table->timestamps();
        });
        DB::statement("SET FOREIGN_KEY_CHECKS = 0;");
        Schema::table('service_class_rate_details', function (Blueprint $table) {
            if (Schema::hasColumn('service_class_rate_details', 'class_id')) 
            {
                $table->dropColumn(['class_id']);
            }
            if (!Schema::hasColumn('service_class_rate_details', 'class_id')) 
            {
                
                $table->unsignedBigInteger('class_id')->nullable()->after('ser_id');
                $table->foreign('class_id')->references('id')->on('class_masters');
            }
           
        });
        DB::statement("SET FOREIGN_KEY_CHECKS = 1;");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('discharge_destination_masters');
        Schema::table('service_class_rate_details', function (Blueprint $table) {
            if (Schema::hasColumn('service_class_rate_details', 'class_id')) 
            {
                $table->dropForeign(['class_id']);
                $table->dropColumn(['class_id']);
            }
        });

    }
}
