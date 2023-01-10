<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreatePackageTariffsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('package_tariffs', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('package_id')->nullable();
            $table->unsignedBigInteger('tariff_id')->nullable();
            $table->text('list_class')->nullable();
            $table->foreign('package_id')->references('id')->on('packages')->onDelete('cascade');
            $table->foreign('tariff_id')->references('id')->on('tariff_masters')->onDelete('cascade');
            $table->timestamps();
        });
        // DB::statement("SET FOREIGN_KEY_CHECKS = 0;");
        // Schema::table('visit_types', function (Blueprint $table) {
        //     if (Schema::hasColumn('visit_types', 'service_id')) 
        //     {
                
        //         $table->unsignedBigInteger('service_id')->nullable()->change();
        //         $table->foreign('service_id')->references('id')->on('service_masters');
        //     }
        // });
        // DB::statement("SET FOREIGN_KEY_CHECKS = 1;");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('package_tariffs');
        // Schema::table('visit_types', function (Blueprint $table) {
        //     $table->integer('service_id')->default(0)->comment('1= active, 0=inactive')->change();
        // });
    }
}
