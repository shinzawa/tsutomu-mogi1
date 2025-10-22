<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ExhibitItemsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $param = [
            'item_id' => '4',
            'user_id' => '1',
        ];
        DB::table('user_exhibit_items')->insert($param);
        $param = [
            'item_id' => '5',
            'user_id' => '2',
        ];
        DB::table('user_exhibit_items')->insert($param);
        $param = [
            'item_id' => '6',
            'user_id' => '3',
        ];
        DB::table('user_exhibit_items')->insert($param);
        $param = [
            'item_id' => '7',
            'user_id' => '1',
        ];
        DB::table('user_exhibit_items')->insert($param);
        $param = [
            'item_id' => '8',
            'user_id' => '2',
        ];
        DB::table('user_exhibit_items')->insert($param);
        $param = [
            'item_id' => '9',
            'user_id' => '3',
        ];
        DB::table('user_exhibit_items')->insert($param);
        $param = [
            'item_id' => '10',
            'user_id' => '1',
        ];
    }
}
