<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class Case01_UserRegisterTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_名前が入力されていない場合、バリデーションメッセージが表示される()
    {
        $response = $this->get('/register');

        $response->assertStatus(200);

        $data = [
            'name' => '',
            'email' => 'test1@example.com',
            'password' => 'coachtech111',
            'password_confirmation' =>  'coachtech111',
        ];
        $response = $this->post('/register', $data);
        $response->assertRedirect('/register');
        $response->assertSessionHasErrors(['name' => 'お名前を入力してください',]);
    }

    public function test_メールアドレスが入力されていない場合、バリデーションメッセージが表示される()
    {
        $response = $this->get('/register');

        $response->assertStatus(200);

        $data = [
            'name' => 'test1',
            'email' => '',
            'password' => 'coachtech111',
            'password_confirmation' =>  'coachtech111',
        ];
        $response = $this->post('/register', $data);
        $response->assertRedirect('/register');
        $response->assertSessionHasErrors(['email' => 'メールアドレスを入力してください',]);
    }

    public function test_パスワードが入力されていない場合、バリデーションメッセージが表示される()
    {
        $response = $this->get('/register');

        $response->assertStatus(200);

        $data = [
            'name' => 'test1',
            'email' => 'test1@example.com',
            'password' => '',
            'password_confirmation' =>  'coachtech111',
        ];
        $response = $this->post('/register', $data);
        $response->assertRedirect('/register');
        $response->assertSessionHasErrors(['password' => 'パスワードを入力してください',]);
    }

    public function test_パスワードが7文字以下の場合、バリデーションメッセージが表示される()
    {
        $response = $this->get('/register');

        $response->assertStatus(200);

        $data = [
            'name' => 'test1',
            'email' => 'test1@example.com',
            'password' => '123456',
            'password_confirmation' =>  'coachtech111',
        ];
        $response = $this->post('/register', $data);
        $response->assertRedirect('/register');
        $response->assertSessionHasErrors(['password' => 'パスワードは8文字以上で入力してください',]);
    }

    public function test_パスワードが確認用パスワードと一致しない場合、バリデーションメッセージが表示される()
    {
        $response = $this->get('/register');

        $response->assertStatus(200);

        $data = [
            'name' => 'test1',
            'email' => 'test1@example.com',
            'password' => 'coachtech111',
            'password_confirmation' =>  'coachtech112',
        ];
        $response = $this->post('/register', $data);
        $response->assertRedirect('/register');
        $response->assertSessionHasErrors(['password' => 'パスワードと一致しません',]);
    }

    public function test_全ての項目が入力されている場合、会員情報が登録され、プロフィール設定画面に遷移される()
    {
        $response = $this->get('/register');

        $response->assertStatus(200);

        $data = [
            'name' => 'test4',
            'email' => 'test4@example.com',
            'password' => 'coachtech114',
            'password_confirmation' =>  'coachtech114',
        ];

        $response = $this->post('/register', $data);
        $response->assertRedirect('/profile/create');
        $user = DB::table('users')->where('email', 'test4@example.com')->first();
        $this->assertEquals($data['name'], $user->name);
        $this->assertEquals($data['email'], $user->email);
        $this->assertTrue(Hash::check($data['password'], $user->password));

        $this->post('/logout');
    }
}
