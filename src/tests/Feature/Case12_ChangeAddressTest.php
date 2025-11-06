<?php

namespace Tests\Feature;

use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class Case12_ChangeAddressTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_送付先住所変更画面にて登録した住所が商品購入画面に反映されている()
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

        $response = $this->get('/purchase/address/5');
        $response->assertStatus(200);

        $data = [
            'zipcode' => '901-2226',
            'address' => '沖縄県宜野湾市嘉数２－２',
            'building' => 'ハイツ嘉数',
        ];

        $response = $this->post('/purchase/address/5', $data);

        $response->assertSeeInOrder(['901-2226', '沖縄県宜野湾市嘉数２－２', 'ハイツ嘉数']);
    }

    public function test_購入した商品に送付先住所が紐づいて登録される()
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

        $response = $this->get('/purchase/address/5');
        $response->assertStatus(200);

        $data = [
            'zipcode' => '901-2226',
            'address' => '沖縄県宜野湾市嘉数２－２',
            'building' => 'ハイツ嘉数',
        ];

        $response = $this->post('/purchase/address/5', $data);
        $response->assertSeeInOrder(['901-2226', '沖縄県宜野湾市嘉数２－２', 'ハイツ嘉数']);

        $purchaseData = ['purchase-method' => 'コンビニ払い', 'zipcode' => '100-1701', 'address' => '東京都青ヶ島村１－１', 'building' => 'ハイツ青ヶ島'];
        $response = $this->post('/purchase/5', $purchaseData);
        $response->assertStatus(200);

        $this->get('/items/index');
        $response->assertStatus(200);
        $response->assertSeeInOrder(['ノートPC', 'Sold', 'マイク']);
        DB::table('user_buy_items')->where('user_id', '1')->where('item_id', '5')->delete();
    }
}
