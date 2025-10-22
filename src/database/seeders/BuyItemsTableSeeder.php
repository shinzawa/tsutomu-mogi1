<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BuyItemsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $param = [
            'item_id' => '1',
            'user_id' => '1',
            'zipcode' => '100-1701',
            'address' => '東京都青ヶ島村１－１',
            'building' => 'ハイツ青ヶ島',
        ];
        DB::table('user_buy_items')->insert($param);
        $param = [
            'item_id' => '2',
            'user_id' => '2',
            'zipcode' => '901-2226',
            'address' => '沖縄県宜野湾市嘉数２－２',
            'building' => 'ハイツ嘉数',
        ];
        DB::table('user_buy_items')->insert($param);
        $param = [
            'item_id' => '3',
            'user_id' => '3',
            'zipcode' => '932-0203',
            'address' => '富山県南砺市岩屋３－３',
            'building' => 'ハイツ岩屋',
        ];
        DB::table('user_buy_items')->insert($param);
    }
}
