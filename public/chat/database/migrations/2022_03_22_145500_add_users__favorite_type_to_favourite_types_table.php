<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class AddUsersFavoriteTypeToFavouriteTypesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('favourite_types', function (Blueprint $table) {
            //
        });
        DB::statement("INSERT INTO `favourite_types` (`id`, `favourite_type`, `favourite_name`, `favourite_description`,`created_at`, `updated_at`) VALUES
        (7, 'users', 'Users', 'Users', '2022-03-22 14:56:00', '2022-03-22 14:56:00');");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('favourite_types', function (Blueprint $table) {
            //
        });
    }
}
