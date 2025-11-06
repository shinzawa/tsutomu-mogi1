<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class Case14_ProfileEditTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_変更項目が初期値として過去設定されていること（プロフィール画像、ユーザー名、郵便番号、住所）()
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

        // call Edit profile
        $response = $this->get('/mypage/profile');
        $response->assertStatus(200);
        $response->assertSee('http://localhost/storage/kiku.jpg');
        $response->assertSeeInOrder(['ユーザー名','test1','郵便番号', '100-1701', '住所', '東京都青ヶ島村１－１', '建物', 'ハイツ青ヶ島']);
    }
}
