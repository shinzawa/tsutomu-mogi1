<?php

namespace Tests\Feature;

use Illuminate\Support\Facades\Auth;
use Tests\TestCase;

class Case09_ItemCommentTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_ログイン済みのユーザーはコメントを送信できる()
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

        $response = $this->get('/items/2');
        $response->assertStatus(200);

        $commentData = ['comment' => 'これは商品２のコメントです。user1'];
        $response = $this->post('/comment/2', $commentData);
//        $response->assertRedirect('/items/2');
    }

    public function test_ログイン前のユーザーはコメントを送信できない()
    {
        $this->assertFalse(Auth::check());
        $response = $this->get('/');
        $response->assertStatus(200);

        $response = $this->get('/items/1');
        $response->assertStatus(200);

        $commentData = ['comment' => 'これは商品２のコメントです。user1'];
        $response = $this->post('/comment/2', $commentData);
        $response->assertDontSee('http://localhost/storage/kiku.jpg');
        $response->assertDontSeeText('test1');
        $response->assertDontSeeText('これは商品２のコメントです。user1');
    }

    public function test_コメントが入力されていない場合、バリデーションメッセージが表示される()
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

        $response = $this->get('/items/2');
        $response->assertStatus(200);

        $commentData = ['comment' => ''];
        $response = $this->post('/comment/2', $commentData);

//        $response->assertRedirect('/items/2');
        $response->assertSessionHasErrors(['comment' => 'コメントを入力してください',]);
    }

    public function test_コメントが255字以上の場合、バリデーションメッセージが表示される()
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

        $response = $this->get('/items/2');
        $response->assertStatus(200);

        $commentData = ['comment' => '0123456789012345678901234567890123456789012345678901234567890123456789012345678901234567890123456789012345678901234\
5678901234567890123456789012345678901234567890123456789012345678901234567890123456789012345678901234567890123456789\
01234567890123456789012345'];
        $response = $this->post('/comment/2', $commentData);

//        $response->assertRedirect('/items/2');
        $response->assertSessionHasErrors(['comment' => 'コメントは255文字以内で入力してください',]);
    }
}
