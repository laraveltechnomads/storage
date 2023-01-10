<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFieldsBibleVersesToFavouritesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('favourites', function (Blueprint $table) {
            $table->string('chapterId')->nullable()->after('select_id');
            $table->string('versionId')->nullable()->after('chapterId');
            $table->string('bookId')->nullable()->after('versionId');
            $table->string('languageId')->nullable()->after('bookId');
            $table->string('verseName')->nullable()->after('languageId');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('favourites', function (Blueprint $table) {
            //
        });
    }
}
