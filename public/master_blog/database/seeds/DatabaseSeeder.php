<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // $this->call(UsersTableSeeder::class);
     
        //Users create
        DB::table('users')->insert([
            'name' => 'Admin',
            'email' => 'admin@test.com',
            'email_verified_at' => now(),
            'password' => '$2a$12$E5NQk/IsK87y07ybBhJqX.QnCvPcZps3ZUZlp8YgK8ByIor8GApuK', // password
            'remember_token' => Str::random(10),
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        DB::table('users')->insert([
            'name' => 'User',
            'email' => 'author@test.com',
            'email_verified_at' => now(),
            'password' => '$2a$12$BET4e9M.dx2UoiZteUmaIuxxlil.RxkBQnzl7nHzBAlDz3LkeUY4m', // password
            'remember_token' => Str::random(10),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Role Create
        DB::table('roles')->insert([
            'name' => 'Admin',
            'guard_name' => 'role_admin',
            'description' => 'Admin',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        DB::table('roles')->insert([
            'name' => 'Author',
            'guard_name' => 'role_author',
            'description' => 'Author',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // User & Role relationship add
        DB::table('role_user')->insert([
            'role_id' => '1',
            'user_id' => '1',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        DB::table('role_user')->insert([
            'role_id' => '2',
            'user_id' => '2',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('model_has_roles')->insert([
            'role_id' => '1',
            'model_type' => 'App\\User',
            'model_id' => '1',
        ]);
        DB::table('model_has_roles')->insert([
            'role_id' => '2',
            'model_type' => 'App\\User',
            'model_id' => '2',
        ]);

        DB::table('permissions')->insert([
            'id' => '1',
            'name' => 'manage_role',
            'guard_name' => 'role_admin',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        DB::table('permissions')->insert([
            'id' => '2',
            'name' => 'manage_permission',
            'guard_name' => 'role_admin',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        DB::table('permissions')->insert([
            'id' => '3',
            'name' => 'manage_user',
            'guard_name' => 'role_admin',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
