<?php

namespace Tests\Browser;

use Illuminate\Support\Facades\DB;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class Case16_email_certificationTest extends DuskTestCase
{
    /**
     * A basic browser test example.
     *
     * @return void
     */
    public function test_会員登録後、認証メールが送信される()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/register')
                ->type('name', 'test4')
                ->type('email', 'test4@example.com')
                ->type('password', 'coachtech114')
                ->type('password_confirmation', 'coachtech114')
                ->press('登録する')
                ->assertPathIs('/email/verify')
                ->clickLink('認証はこちらから');
            // MailHog API にアクセスしてメールを確認
            $response = file_get_contents('http://mailhog:8025/api/v2/messages');
            $messages = json_decode($response, true);

            $this->assertNotEmpty($messages['items']);
            $this->assertStringContainsString(
                '/email/verify',
                $messages['items'][0]['Content']['Body']
            );
        });

        DB::table('users')->where('name', 'test4')->delete();
    }

    public function test_メール認証誘導画面で「認証はこちらから」ボタンを押下するとメール認証サイトに遷移する()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/register')
                ->type('name', 'test5')
                ->type('email', 'test5@example.com')
                ->type('password', 'coachtech115')
                ->type('password_confirmation', 'coachtech115')
                ->press('登録する')
                ->assertPathIs('/email/verify')
                ->clickLink('認証はこちらから');
            // 2. MailHog API から最新メールを取得
            $response = file_get_contents('http://mailhog:8025/api/v2/messages');
            $messages = json_decode($response, true);
            $body = $messages['items'][0]['Content']['Body'];

            // Quoted-Printable をデコード
            $decodedBody = quoted_printable_decode($body);

            // 改行を除去
            $decodedBody = str_replace("\n", "", $decodedBody);

            // 3. 本文から認証リンクを抽出
            $result = preg_match('/http:\/\/nginx\/email\/verify[^\s"]+/', $decodedBody, $matches);
            $this->assertStringStartsWith('http://nginx/email/verify', $matches[0]);
        });
        DB::table('users')->where('name', 'test5')->delete();
    }

    public function test_メール認証サイトのメール認証を完了すると、プロフィール設定画面に遷移する()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/register')
                ->type('name', 'test6')
                ->type('email', 'test6@example.com')
                ->type('password', 'coachtech116')
                ->type('password_confirmation', 'coachtech116')
                ->press('登録する')
                ->assertPathIs('/email/verify')
                ->clickLink('認証はこちらから');
            // 2. MailHog API から最新メールを取得
            $response = file_get_contents('http://mailhog:8025/api/v2/messages');
            $messages = json_decode($response, true);
            $body = $messages['items'][0]['Content']['Body'];

            // Quoted-Printable をデコード
            $decodedBody = quoted_printable_decode($body);

            // 改行を除去
            $decodedBody = str_replace("\n", "", $decodedBody);

            // 3. 本文から認証リンクを抽出
            preg_match('/http:\/\/nginx\/email\/verify[^\s"]+/', $decodedBody, $matches);
            $verifyUrl = $matches[0];

            // 4. Dusk で認証リンクにアクセス
            $browser->visit($verifyUrl)
                ->assertPathBeginsWith('/profile/create');
        });
        DB::table('users')->where('name', 'test6')->delete();
    }
}
