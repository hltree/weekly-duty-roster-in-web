<?php

use Illuminate\Database\Seeder;

class MemberSeeder extends Seeder
{
    /**
     * Run the database seeds.
     * @return void
     *
     * Test Users
     */
    public function run()
    {
        $members = new \App\Models\Member([
            'name' => 'テストメンバー',
            'exclude_week' => 'mon'
        ]);
        $members->save();

        $members = new \App\Models\Member([
            'name' => 'テストメンバー２',
            'exclude_week' => 'wed,fri'
        ]);
        $members->save();

        $members = new \App\Models\Member([
            'name' => 'テストメンバー３',
            'exclude_week' => ''
        ]);
        $members->save();
    }
}
