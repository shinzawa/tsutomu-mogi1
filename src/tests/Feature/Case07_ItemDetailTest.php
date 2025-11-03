<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class Case07_ItemDetailTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_必要な情報が表示される（商品画像、商品名、ブランド名、価格、いいね数、コメント数、商品説明、商品情報（カテゴリ、商品の状態）、コメント数、コメントしたユーザー情報、コメント内容）()
    {
        $response = $this->get('/');
        $response->assertStatus(200);

        $response = $this->get('/items/1');
        $response->assertStatus(200);
        $response->assertSee('http://localhost/storage/Armani+Mens+Clock.jpg');
        $response->assertSeeText('腕時計');
        $response->assertSeeText('Rolax');
        $response->assertSeeText('15,000');
        $response->assertSeeText('1');
        $response->assertSeeText('3');
        $response->assertSeeText('スタイリッシュなデザインのメンズ腕時計');
        $response->assertSeeInOrder(['商品の情報', 'カテゴリ', 'ファッション', 'メンズ', 'アクセサリ']);
        $response->assertSeeInOrder(['商品の状態', '良好']);
        $response->assertSeeText('コメント(3)');
        $response->assertSee('http://localhost/storage/kiku.jpg');
        $response->assertSeeText('test1');
        $response->assertSeeText('これは商品１のコメントです。user1');
        $response->assertSee('http://localhost/storage/sakura.jpg');
        $response->assertSeeText('test2');
        $response->assertSeeText('これは商品１のコメントです。user2');
        $response->assertSee('http://localhost/storage/rose.jpg');
        $response->assertSeeText('test3');
        $response->assertSeeText('これは商品１のコメントです。user3');
    }

    public function test_複数選択されたカテゴリが表示されているか()
    {
        $response = $this->get('/');
        $response->assertStatus(200);

        $response = $this->get('/items/1');
        $response->assertStatus(200);
        $response->assertSeeInOrder(['商品の情報', 'カテゴリ', 'ファッション', 'メンズ', 'アクセサリ']);
    }
}
