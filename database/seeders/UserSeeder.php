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
        $users = [
            'email' => 'rizal@gmail.com',
            'password' => Hash::make('rizal@2022')
        ];

        User::create($users);
    }
}
