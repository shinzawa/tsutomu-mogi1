<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProfilesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $param = [
            'user_id' => '1',
            'name' => 'test1',
            'image' => 'kiku.jpg',
            'zipcode' => '100-1701',
            'address' => '東京都青ヶ島村１－１',
            'building' => 'ハイツ青ヶ島',
        ];
        DB::table('profiles')->insert($param);
        $param = [
            'user_id' => '2',
            'name' => 'test2',
            'image' => 'sakura.jpg',
            'zipcode' => '901-2226',
            'address' => '沖縄県宜野湾市嘉数２－２',
            'building' => 'ハイツ嘉数',
        ];
        DB::table('profiles')->insert($param);
        $param = [
            'user_id' => '3',
            'name' => 'test3',
            'image' => 'rose.jpg',
            'zipcode' => '932-0203',
            'address' => '富山県南砺市岩屋３－３',
            'building' => 'ハイツ岩屋',
        ];
        DB::table('profiles')->insert($param);
    }
}
