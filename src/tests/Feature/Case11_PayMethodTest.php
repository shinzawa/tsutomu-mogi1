<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class Case11_PayMethodTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_小計画面で変更が反映される()
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

        $response = $this->get('/items/5');
        $response->assertStatus(200);

        $response = $this->get('/purchase/5');
        $response->assertStatus(200);
        $response->assertSeeInOrder(['コンビニ払い', 'コンビニ払い', 'コンビニ払い']);

        $response = $this->get('/items/4');
        $response->assertStatus(200);
        $response = $this->get('/purchase/4');
        $response->assertStatus(200);
        $response->assertSeeInOrder(['カード支払い', 'カード支払い', 'コンビニ払い']);
    }
}
