<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;

class ProfilesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user1 = User::where('email', 'test1@example.com')->first();
        if ($user1) {
            $user1->profile()->updateOrCreate(
                [],
                [
                    'postcode' => '123-4567',
                    'address'  => '東京都新宿区テスト町1-1-1',
                    'building' => 'テストマンション101',
                    'image'    => null,
                ]
            );
        }

        $user2 = User::where('email', 'test2@example.com')->first();
        if ($user2) {
            $user2->profile()->updateOrCreate(
                [],
                [
                    'postcode' => '987-6543',
                    'address'  => '東京都渋谷区テスト町2-2-2',
                    'building' => 'テストマンション202',
                    'image'    => null,
                ]
            );
        }
    }
}
