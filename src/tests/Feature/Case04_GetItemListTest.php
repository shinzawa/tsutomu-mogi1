<?php

namespace Tests\Feature;

use Illuminate\Support\Facades\Auth;
use Tests\TestCase;

class Case04_GetItemListTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_全商品を取得できる()
    {
        $response = $this->get('/');
        $response->assertStatus(200);
        $this->assertFalse(Auth::check());
        $response->assertSeeText('腕時計');
        $response->assertSeeText('HDD');
        $response->assertSeeText('玉ねぎ3束');
        $response->assertSeeText('革靴');
        $response->assertSeeText('ノートPC');
        $response->assertSeeText('マイク');
        $response->assertSeeText('ショルダーバッグ');
        $response->assertSeeText('タンブラー');
        $response->assertSeeText('コーヒーミル');
        $response->assertSeeText('メイクセット');
    }

    public function test_購入済み商品は「Sold」と表示される()
    {
        $response = $this->get('/');
        $response->assertStatus(200);
        $this->assertFalse(Auth::check());
        $response->assertSeeInOrder(['腕時計', 'Sold', 'HDD', 'Sold', '玉ねぎ3束', 'Sold']);
    }

    public function test_自分が出品した商品は表示されない()
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


        $response = $this->get('/');
        $response->assertStatus(200);
        $response->assertSeeText('腕時計');
        $response->assertSeeText('HDD');
        $response->assertSeeText('玉ねぎ3束');
        $response->assertDontSeeText('革靴');
        $response->assertSeeText('ノートPC');
        $response->assertSeeText('マイク');
        $response->assertDontSeeText('ショルダーバッグ');
        $response->assertSeeText('タンブラー');
        $response->assertSeeText('コーヒーミル');
        $response->assertSeeText('メイクセット');
    }
}
