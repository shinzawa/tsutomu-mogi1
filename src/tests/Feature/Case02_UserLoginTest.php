<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class Case02_UserLoginTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_メールアドレスが入力されていない場合、バリデーションメッセージが表示される()
    {
        $response = $this->get('/login');

        $response->assertStatus(200);

        $data = [
            'email' => '',
            'password' => 'coachtech111',
        ];
        $response = $this->post('/login', $data);
        $response->assertRedirect('/login');
        $response->assertSessionHasErrors(['email' => 'メールアドレスを入力してください',]);
    }

    public function test_パスワードが入力されていない場合、バリデーションメッセージが表示される()
    {
        $response = $this->get('/login');

        $response->assertStatus(200);

        $data = [
            'email' => 'test1@example.com',
            'password' => '',
        ];
        $response = $this->post('/login', $data);
        $response->assertRedirect('/login');
        $response->assertSessionHasErrors(['password' => 'パスワードを入力してください',]);
    }

    public function test_入力情報が間違っている場合、バリデーションメッセージが表示される()
    {
        $response = $this->get('/login');

        $response->assertStatus(200);

        $data = [
            'email' => 'test1',
            'password' => 'coachtech111',
        ];
        $response = $this->post('/login', $data);
        $response->assertRedirect('/login');
        $response->assertSessionHasErrors(['email' => 'ログイン情報が登録されていません',]);
    }

    public function test_正しい情報が入力された場合、ログイン処理が実行される()
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
    }
}
