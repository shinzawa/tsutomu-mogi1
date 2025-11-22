<?php

namespace Tests\Feature;

use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class Case10_ItemBuyTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_「購入する」ボタンを押下すると購入が完了する()
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

        $response = $this->get('/items/5');
        $response->assertStatus(200);

        $response = $this->get('/purchase/5');
        $response->assertStatus(200);

        $purchaseData = [
            'name' => 'ノートPC',
            'price' => '45000',
            'purchase-method' => 'コンビニ払い',
            'zipcode' => '100-1701',
            'address' => '東京都青ヶ島村１－１',
            'building' => 'ハイツ青ヶ島'];
        $response = $this->post('/purchase/5', $purchaseData);
        // $response->assertStatus(200);

        $item = DB::table('user_buy_items')->where('user_id', '1')->where('item_id', '5')->first();
        $this->assertEquals($purchaseData['zipcode'], $item->zipcode);
        $this->assertEquals($purchaseData['address'], $item->address);
        $this->assertEquals($purchaseData['building'], $item->building);
        DB::table('user_buy_items')->where('user_id', '1')->where('item_id', '5')->delete();
    }

    public function test_購入した商品は商品一覧画面にて「sold」と表示される()
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

        $response = $this->get('/items/5');
        $response->assertStatus(200);

        $response = $this->get('/purchase/5');
        $response->assertStatus(200);

        $purchaseData = [
            'name' => 'ノートPC',
            'price' => '45000',
            'purchase-method' => 'コンビニ払い',
            'zipcode' => '100-1701',
            'address' => '東京都青ヶ島村１－１',
            'building' => 'ハイツ青ヶ島'
        ];
        $response = $this->post('/purchase/5', $purchaseData);
        // $response->assertStatus(200);

        $this->get('/items/index');
        // $response->assertStatus(200);
        $response->assertSeeInOrder(['ノートPC', 'Sold', 'マイク']);
        DB::table('user_buy_items')->where('user_id', '1')->where('item_id', '5')->delete();
    }

    public function test_「プロフィール／購入した商品一覧」に追加されている()
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

        $response = $this->get('/items/5');
        $response->assertStatus(200);

        $response = $this->get('/purchase/5');
        $response->assertStatus(200);

        $purchaseData = [
            'name' => 'ノートPC',
            'price' => '45000',
            'purchase-method' => 'コンビニ払い',
            'zipcode' => '100-1701',
            'address' => '東京都青ヶ島村１－１',
            'building' => 'ハイツ青ヶ島'
        ];
        $response = $this->post('/purchase/5', $purchaseData);
        // $response->assertStatus(200);

        $response = $this->get('/mypage');
        $response->assertStatus(200);

        $response = $this->get('/mypage?page=buy');
        $response->assertStatus(200);

        
        $response->assertSeeText('ノートPC');
        DB::table('user_buy_items')->where('user_id', '1')->where('item_id', '5')->delete();
    }
}
