<?php

namespace Tests\Feature;

use Illuminate\Support\Facades\Auth;
use Tests\TestCase;

class Case05_GetMylistTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_いいねした商品だけが表示される()
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

        $response = $this->get('/mylist');
        $response->assertStatus(200);

        $response->assertSeeText('腕時計');
        $response->assertSeeText('革靴');
        $response->assertSeeText('ショルダーバッグ');
        $response->assertSeeText('メイクセット');
        $response->assertDontSeeText('HDD');
        $response->assertDontSeeText('玉ねぎ3束');
        $response->assertDontSeeText('ノートPC');
        $response->assertDontSeeText('マイク');
        $response->assertDontSeeText('タンブラー');
        $response->assertDontSeeText('コーヒーミル');
    }

    public function test_購入済み商品は「Sold」と表示される()
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

        $response = $this->get('/mylist');
        $response->assertStatus(200);
        $response->assertSeeInOrder(['腕時計', 'Sold', '革靴', 'ショルダーバッグ', 'メイクセット']);
        $response->assertDontSeeText('HDD');
        $response->assertDontSeeText('玉ねぎ3束');
        $response->assertDontSeeText('ノートPC');
        $response->assertDontSeeText('マイク');
        $response->assertDontSeeText('タンブラー');
        $response->assertDontSeeText('コーヒーミル');
    }

    public function test_未認証の場合は何も表示されない()
    {
        $this->assertFalse(Auth::check());

        $response = $this->get('/mylist');
        $response->assertStatus(200);

        $response->assertDontSeeText('腕時計');
        $response->assertDontSeeText('革靴');
        $response->assertDontSeeText('ショルダーバッグ');
        $response->assertDontSeeText('メイクセット');
        $response->assertDontSeeText('HDD');
        $response->assertDontSeeText('玉ねぎ3束');
        $response->assertDontSeeText('ノートPC');
        $response->assertDontSeeText('マイク');
        $response->assertDontSeeText('タンブラー');
        $response->assertDontSeeText('コーヒーミル');
    }
}
