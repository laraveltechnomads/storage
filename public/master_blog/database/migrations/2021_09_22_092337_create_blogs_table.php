<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBlogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('blogs', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('user_id')->foreign('user_id')->references('id')->on('users')->nullable(); 
            $table->string('author', 255)->nullable();
            $table->string('slug', 255)->unique(); // Index
            $table->string('meta_title', 255)->nullable();
            $table->string('meta_description', 255)->nullable();
            // VARCHAR equivalent column with a length.
            $table->string('title', 255)->nullable();  
            $table->string('sub_title', 255)->nullable();
            $table->json('tag_id', 255)->nullable();
            $table->json('category', 255)->nullable();
            $table->json('sub_category', 255)->nullable();
            // TEXT equivalent column.
            $table->text('description')->nullable(); 
            $table->string('feature_image', 255)->nullable();
            $table->string('like', 255)->nullable();
            $table->string('dislike', 255)->nullable();
            $table->tinyInteger('status')->default('1');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('blogs');
    }
}