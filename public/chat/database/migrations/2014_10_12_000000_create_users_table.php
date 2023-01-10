<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->rememberToken();
            $table->string('u_type')->default('USR')->comment('ADM=Admin, USR=User, CHR=Church');
            $table->timestamps();
            $table->softDeletes();
        });

        DB::statement("INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `remember_token`, `u_type`, `created_at`, `updated_at` , `deleted_at`) VALUES
        (1, 'Admin','admin@test.com', '2021-10-22 11:10:15','admin@123', NULL, 'ADM','2021-10-22 20:00:47', '2021-10-22 00:57:15', NULL)");

        DB::statement('UPDATE `users` SET `password` = "$2a$12$2kkEKi9W.YGAFOZVyxI7f..CveZ5KxLWKxNvbprKTq0/WunjfHFIm" WHERE `users`.`id` = 1;');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
