<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->updateOrInsert(
            ['email' => 'test1@example.com'],
            ['name' => 'テストユーザー1', 'password' => Hash::make('password')]
        );

        DB::table('users')->updateOrInsert(
            ['email' => 'test2@example.com'],
            ['name' => 'テストユーザー2', 'password' => Hash::make('password')]
        );

        DB::table('users')->updateOrInsert(
            ['email' => 'test3@example.com'],
            ['name' => 'テストユーザー3', 'password' => Hash::make('password')]
        );
    }
}
