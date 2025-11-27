<?php

namespace Tests\Feature;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\UploadedFile;
use Tests\TestCase;

class Case15_ItemExhibitTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_商品出品画面にて必要な情報が保存できること（カテゴリ、商品の状態、商品名、ブランド名、商品の説明、販売価格）()
    {
        $response = $this->get('/login');
        $response->assertStatus(200);
        $response->assertSeeText('メールアドレス');
        $data = [
            'email' => 'test1@example.com',
            'password' => 'coachtech111',
        ];
        $response = $this->post('/login', $data);
        $response->assertRedirect('/');
        $this->assertAuthenticated();

        // 商品出品画面
        $response = $this->get('/exhibit');
        $response->assertStatus(200);

        $filePath = __DIR__ . '/../../storage/app/public/kiku.jpg'; // テストファイルのパス

        $file = new UploadedFile(
            $filePath,
            'kiku.jpg',
            'image/jpg', // MIMEタイプ
            null,
            true // $test パラメータを true に設定
        );

        $data = ['name' => 'キク',
                 'brand' => 'Fiore',
                 'price' => '5900',
                 'description' => 'キクは食べられる', 
                 'condition' => '2',
		 'image' => 'kiku.jpg',
                 'categories' => ['1','3','5']
		 ];
        $data = array_merge($data, ['image' => $file]);
        $response = $this->post('/exhibit', $data);

        $item = DB::table('items')->where('name', 'キク')->first();
        $this->assertEquals($data['name'], $item->name);
        $this->assertEquals($data['price'], $item->price);
        $this->assertEquals($data['brand'], $item->brand);
        $this->assertEquals($data['description'], $item->description);
        $this->assertEquals($data['condition'], $item->condition);

        $exhibit = ['id' => 7, 'user_id' => 1, 'item_id' => 11];
        $this->assertDataBaseHas('user_exhibit_items', $exhibit);
	
	$category = ['item_id' => 11, 'category_id' => 1];
        $this->assertDataBaseHas('item_category', $category);
	$category = ['item_id' => 11, 'category_id' => 3];
        $this->assertDataBaseHas('item_category', $category);
	$category = ['item_id' => 11, 'category_id' => 5];
        $this->assertDataBaseHas('item_category', $category);
	
        DB::table('items')->where('name', 'キク')->delete();
        DB::table('item_category')->where('item_id', '15')->delete();
        DB::table('user_exhibit_items')->where('user_id', '1')->where('item_id', '11')->delete();
    }
}
