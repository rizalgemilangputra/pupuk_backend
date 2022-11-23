<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $time = date('Y-m-d');
        $users = [
            [
                'email'    => 'rizal@gmail.com',
                'password' => Hash::make('rizal@2022'),
                'token'    => 't5HyLfctpAwNhplxUdq01K3UI9BWct2boRAXqvU3EKrCLVeAWPrydrvfidrhQRvfVS5GHe2U8CQSYC0Q',
                'created_at'    => $time,
                'updated_at'    => $time,
            ],
            [
                'email'    => 'yohanes@gmail.com',
                'password' => Hash::make('yohanes@2022'),
                'token'    => 't5HyLfctpAwNhplxUdq01K3UI9BWct2boRAXqvU3EKrCLVeAWPrydrvfidrhQRvfVS5GHe2U8CQSYzzz',
                'created_at'    => $time,
                'updated_at'    => $time,
            ],
        ];

        User::insert($users);
    }
}
