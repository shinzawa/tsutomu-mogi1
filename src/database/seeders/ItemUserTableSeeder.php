<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ItemUserTableSeeder extends Seeder
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
            'comment' => 'これは商品１のコメントです。user1'
        ];
        DB::table('item_user')->insert($param);
        $param = [
            'item_id' => '1',
            'user_id' => '2',
            'comment' => 'これは商品１のコメントです。user2'
        ];
        DB::table('item_user')->insert($param);
        $param = [
            'item_id' => '1',
            'user_id' => '3',
            'comment' => 'これは商品１のコメントです。user3'
        ];
        DB::table('item_user')->insert($param);
        $param = [
            'item_id' => '2',
            'user_id' => '2',
            'comment' => 'これは商品２のコメントです。user2'
        ];
        DB::table('item_user')->insert($param);
        $param = [
            'item_id' => '3',
            'user_id' => '1',
            'comment' => 'これは商品３のコメントです。user1'
        ];
        DB::table('item_user')->insert($param);
        $param = [
            'item_id' => '4',
            'user_id' => '2',
            'comment' => 'これは商品４のコメントです。user2'
        ];
        DB::table('item_user')->insert($param);
        $param = [
            'item_id' => '5',
            'user_id' => '2',
            'comment' => 'これは商品５のコメントです。user2'
        ];
        DB::table('item_user')->insert($param);
        $param = [
            'item_id' => '6',
            'user_id' => '2',
            'comment' => 'これは商品６のコメントです。user2'
        ];
        DB::table('item_user')->insert($param);
        $param = [
            'item_id' => '7',
            'user_id' => '1',
            'comment' => 'これは商品７のコメントです。user1'
        ];
        DB::table('item_user')->insert($param);
        $param = [
            'item_id' => '7',
            'user_id' => '3',
            'comment' => 'これは商品７のコメントです。user3'
        ];
        DB::table('item_user')->insert($param);
        $param = [
            'item_id' => '8',
            'user_id' => '1',
            'comment' => 'これは商品８のコメントです。user1'
        ];
        DB::table('item_user')->insert($param);
        $param = [
            'item_id' => '9',
            'user_id' => '2',
            'comment' => 'これは商品９のコメントです。user2'
        ];
        DB::table('item_user')->insert($param);
        $param = [
            'item_id' => '10',
            'user_id' => '1',
            'comment' => 'これは商品１０のコメントです。user1'
        ];
        DB::table('item_user')->insert($param);
        $param = [
            'item_id' => '10',
            'user_id' => '3',
            'comment' => 'これは商品１０のコメントです。user3'
        ];
        DB::table('item_user')->insert($param);
    }
}
