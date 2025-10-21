<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ItemsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $param = [
            'name' => '腕時計',
            'price' => '15000',
            'brand' => 'Rolax',
            'description' => 'スタイリッシュなデザインのメンズ腕時計',
            'image' => 'Armani+Mens+Clock.jpg',
            'condition' => '1',
        ];
        DB::table('items')->insert($param);
        $param = [
            'name' => 'HDD',
            'price' => '5000',
            'brand' => '西芝',
            'description' => '高速で信頼性の高いハードディスク',
            'image' => 'HDD+Hard+Disk.jpg',
            'condition' => '2',
        ];
        DB::table('items')->insert($param);
        $param = [
            'name' => '玉ねぎ3束',
            'price' => '300',
            'brand' => 'なし',
            'description' => '新鮮な玉ねぎ3束のセット',
            'image' => 'iLoveIMG+d.jpg',
            'condition' => '3',
        ];
        DB::table('items')->insert($param);
        $param = [
            'name' => '革靴',
            'price' => '4000',
            'brand' => '',
            'description' => 'クラシックなデザインの革靴',
            'image' => 'Leather+Shoes+Product+Photo.jpg',
            'condition' => '4',
        ];
        DB::table('items')->insert($param);
        $param = [
            'name' => 'ノートPC',
            'price' => '45000',
            'brand' => '',
            'description' => '高性能なノートパソコン',
            'image' => 'Living+Room+Laptop.jpg',
            'condition' => '1',
        ];
        DB::table('items')->insert($param);
        $param = [
            'name' => 'マイク',
            'price' => '8000',
            'brand' => 'なし',
            'description' => '高音質のレコーディング用マイク',
            'image' => 'Music+Mic+4632231.jpg',
            'condition' => '2',
        ];
        DB::table('items')->insert($param);
        $param = [
            'name' => 'ショルダーバッグ',
            'price' => '3500',
            'brand' => '',
            'description' => 'おしゃれなショルダーバッグ',
            'image' => 'Purse+fashion+pocket.jpg',
            'condition' => '3',
        ];
        DB::table('items')->insert($param);
        $param = [
            'name' => 'タンブラー',
            'price' => '500',
            'brand' => 'なし',
            'description' => '使いやすいタンブラー',
            'image' => 'Tumbler+souvenir.jpg',
            'condition' => '4',
        ];
        DB::table('items')->insert($param);
        $param = [
            'name' => 'コーヒーミル',
            'price' => '4000',
            'brand' => 'Starbacks',
            'description' => '手動のコーヒーミル',
            'image' => 'Waitress+with+Coffee+Grinder.jpg',
            'condition' => '1',
        ];
        DB::table('items')->insert($param);
        $param = [
            'name' => 'メイクセット',
            'price' => '2500',
            'brand' => '',
            'description' => '便利なメイクアップセット',
            'image' => '%E5%A4%96%E5%87%BA%E3%83%A1%E3%82%A4%E3%82%AF%E3%82%A2%E3%83%83%E3%83%95%E3%82%9A%E3%82%BB%E3%83%83%E3%83%88.jpg',
            'condition' => '2',
        ];
        DB::table('items')->insert($param);
    }
}