<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class Case13_ProfileShowTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_必要な情報が取得できる（プロフィール画像、ユーザー名、出品した商品一覧、購入した商品一覧）()
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

        $response = $this->get('/mypage');
        $response->assertStatus(200);
        // user profile image and name
        $response->assertSee('http://localhost/storage/kiku.jpg');
        $response->assertSeeText('test1');
        // exhibit items
        $response->assertSee('http://localhost/storage/Leather+Shoes+Product+Photo.jpg');
        $response->assertSeeText('革靴');
        $response->assertSee('http://localhost/storage/Purse+fashion+pocket.jpg');
        $response->assertSeeText('ショルダーバッグ');

        $response = $this->get('/mypage?page=buy');
        $response->assertStatus(200);
        // user profile image and name
        $response->assertSee('http://localhost/storage/kiku.jpg');
        $response->assertSeeText('test1');
        // purchase items
        $response->assertSee('http://localhost/storage/Armani+Mens+Clock.jpg');
        $response->assertSeeText('腕時計');
    }
}
