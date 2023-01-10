<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class InsertValuesToFavouriteTypesTable extends Migration
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
        (1, 'messages', 'Messages', 'Messages from chat', '2021-12-08 12:00:00', '2021-12-08 12:00:00'),
        (2, 'posts', 'Posts', 'Posts from news feed (posted by any user)', '2021-12-08 12:00:00', '2021-12-08 12:00:00'),
        (3, 'songs', 'Songs', 'Songs', '2021-12-08 12:00:00', '2021-12-08 12:00:00'),
        (4, 'diary_posts', 'Diary posts', 'Diary posts', '2021-12-08 12:00:00', '2021-12-08 12:00:00'),
        (5, 'bible_verses', 'Bible verses', 'Bible verses', '2021-12-08 12:00:00', '2021-12-08 12:00:00'),
        (6, 'calendar_events', 'Calendar events', 'Calendar events', '2021-12-08 12:00:00', '2021-12-08 12:00:00');");
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
