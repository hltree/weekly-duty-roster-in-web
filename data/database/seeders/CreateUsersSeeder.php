<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class CreateUsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::truncate();
        User::insert(
            [
                'name' => 'Admin',
                'email' => 'admin@web-duty-roster.com',
                'is_admin' => 1,
                'password' => Hash::make('password')
            ]
        );

        $basicUsers = [];
        for ($i = 1; $i <= 10; $i++) {
            $basicUsers[] = [
                'name' => 'User' . $i,
                'email' => 'user' . $i . '@web-duty-roster.com',
                'password' => Hash::make('password')
            ];
        }

        User::insert($basicUsers);
    }
}
