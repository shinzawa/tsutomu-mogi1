<?php

namespace Tests\Feature;

use Tests\TestCase;

class Case06_SearchItemsTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_「商品名」で部分一致検索ができる()
    {
        $response = $this->get('/login');
        $response->assertStatus(200);
        $response->assertSeeText('メールアドレス');
        $data = [
            'email' => 'test1@example.com',
            'password' => 'coachtech111',
        ];
        $response = $this->post('/login', $data);
//        $response->assertRedirect('/');
        $this->assertAuthenticated();
        
        $response = $this->get('/');
        $response->assertStatus(200);

        $response = $this->get('/?itemname=ク');

        $response->assertStatus(200);
        $response->assertDontSeeText('腕時計');
        $response->assertDontSeeText('革靴');
        $response->assertDontSeeText('ショルダーバッグ');
        $response->assertSeeText('メイクセット');
        $response->assertDontSeeText('HDD');
        $response->assertDontSeeText('玉ねぎ3束');
        $response->assertDontSeeText('ノートPC');
        $response->assertSeeText('マイク');
        $response->assertDontSeeText('タンブラー');
        $response->assertDontSeeText('コーヒーミル');
    }

    public function test_検索状態がマイリストでも保持されている()
    {
        $response = $this->get('/login');
        $response->assertStatus(200);
        $response->assertSeeText('メールアドレス');
        $data = [
            'email' => 'test1@example.com',
            'password' => 'coachtech111',
        ];
        $response = $this->post('/login', $data);
//        $response->assertRedirect('/');
        $this->assertAuthenticated();

        $response = $this->get('/mylist?itemname=ク');
        $response->assertStatus(200);

        $response->assertStatus(200);
        $response->assertDontSeeText('腕時計');
        $response->assertDontSeeText('革靴');
        $response->assertDontSeeText('ショルダーバッグ');
        $response->assertSeeText('メイクセット');
        $response->assertDontSeeText('HDD');
        $response->assertDontSeeText('玉ねぎ3束');
        $response->assertDontSeeText('ノートPC');
        $response->assertDontSeeText('マイク');
        $response->assertDontSeeText('タンブラー');
        $response->assertDontSeeText('コーヒーミル');
    }
}
