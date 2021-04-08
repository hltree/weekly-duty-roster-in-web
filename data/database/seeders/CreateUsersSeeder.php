<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
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
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('users')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
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
                'password' => Hash::make('password'),
                'is_schedule_active' => 1
            ];
        }

        User::insert($basicUsers);
    }
}
