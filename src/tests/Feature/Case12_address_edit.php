<?php

namespace Tests\Browser;

use Illuminate\Support\Facades\DB;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class Case12_address_edit extends DuskTestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
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

        $purchaseData = [
            'name' => 'ノートPC',
            'price' => '45000',
            'purchase-method' => 'コンビニ払い',
            'zipcode' => '683-0937',
            'address' => '鳥取県米子市角盤町３－１０',
            'building' => 'ハイツ青山'
        ];
        $response = $this->post('/purchase/address/5', $purchaseData);
	$newaddress = $response->$newaddress;
	$purchaseData = [
            'name' => 'ノートPC',
            'price' => '45000',
            'purchase-method' => 'コンビニ払い',
            'zipcode' => $newaddress['zipcode'],
            'address' => $newaddress['address'],
            'building' => $newaddress['building'],
        ];
        $response = $this->post('/purchase/5', $purchaseData);
        $item = DB::table('user_buy_items')->where('user_id', '1')->where('item_id', '5')->first();
        $this->assertEquals($purchaseData['zipcode'], $item->zipcode);
        $this->assertEquals($purchaseData['address'], $item->address);
        $this->assertEquals($purchaseData['building'], $item->building);
        DB::table('user_buy_items')->where('user_id', '1')->where('item_id', '5')->delete();
    }
}
