<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
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
        $param = [
            'name' => 'test1',
            'email' => 'test1@example.com',
            'password' => bcrypt('coachtech111')
        ];
        DB::table('users')->insert($param);
        $param = [
            'name' => 'test2',
            'email' => 'test2@example.com',
            'password' => bcrypt('coachtech112')
        ];
        DB::table('users')->insert($param);
        $param = [
            'name' => 'test3',
            'email' => 'test3@example.com',
            'password' => bcrypt('coachtech113')
        ];
        DB::table('users')->insert($param);
    }
}
