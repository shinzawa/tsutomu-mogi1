<?php

namespace Tests\Feature;

use Illuminate\Support\Facades\Auth;
use Tests\TestCase;

class Case03_UserLogoutTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_ログアウトができる()
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

        $response = $this->post('/logout')->assertRedirect('/');
        $this->assertFalse(Auth::check());
    }
}
