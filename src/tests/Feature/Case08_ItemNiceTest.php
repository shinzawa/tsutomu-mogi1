<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class Case08_ItemNiceTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_いいねアイコンを押下することによって、いいねした商品として登録することができる。()
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

        $response = $this->get('/items/2');
        $response->assertStatus(200);

        $response->assertSeeInOrder(['5,000', '1']);

        $response = $this->get('/items/nice/2');
        $response->assertStatus(200);

        $response->assertSeeInOrder(['5,000', '2']);

        $response = $this->get('/items/nice/2');
    }

    public function test_追加済みのアイコンは色が変化する()
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

        $response = $this->get('/items/2');
        $response->assertStatus(200);

        $response->assertSeeInOrder(['5,000', '../../../star8.png', '1']);

        $response = $this->get('/items/nice/2');
        $response->assertStatus(200);

        $response->assertSeeInOrder(['5,000', '../../../star8red.png','2']);

        $response = $this->get('/items/nice/2');
    }

    public function test_再度いいねアイコンを押下することによって、いいねを解除することができる。()
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

        $response = $this->get('/items/2');
        $response->assertStatus(200);

        $response->assertSeeInOrder(['5,000', '../../../star8.png', '1']);

        $response = $this->get('/items/nice/2');
        $response->assertStatus(200);

        $response->assertSeeInOrder(['5,000', '../../../star8red.png', '2']);

        $response = $this->get('/items/nice/2');
        $response->assertStatus(200);

        $response->assertSeeInOrder(['5,000', '../../../star8.png', '1']);
    }
}
