<?php

namespace Tests\Browser;

use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class Case11_payment_method extends DuskTestCase
{
    /**
     * A basic browser test example.
     *
     * @return void
     */
    public function test_小計画面で変更が反映される()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/login')
                ->type('email', 'test1@example.com')
                ->type('password', 'coachtech111')
                ->press('ログインする')
                ->assertPathIs('/')
                ->assertSeeIn('.index-card__list:nth-of-type(5) .index-card__item .index-card__title .index-card__title-name', 'マイク')
                ->click('.index-card__list:nth-of-type(5) .index-card__item')
                ->assertPathIs('/items/6')
                ->press('購入手続きへ')
                ->assertPathIs('/purchase/6')
                ->select('#purchase-method-select', 'コンビニ払い')
                ->pause(500)
                ->assertSeeIn('#display-purchase-method', 'コンビニ払い');
        });
    }
}
