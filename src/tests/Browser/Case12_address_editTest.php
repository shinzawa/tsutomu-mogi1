<?php

namespace Tests\Browser;

use Illuminate\Support\Facades\DB;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class Case12_address_editTest extends DuskTestCase
{
    /**
     * A basic browser test example.
     *
     * @return void
     */
    public function test_送付先住所変更画面にて登録した住所が商品購入画面に反映されている()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/login')
                ->type('email', 'test1@example.com')   // email フィールドに入力
                ->type('password', 'coachtech111')     // password フィールドに入力
                ->press('ログインする')
                ->assertPathIs('/')
                ->assertSeeIn('.index-card__list:nth-of-type(5) .index-card__item .index-card__title .index-card__title-name', 'マイク')
                ->click('.index-card__list:nth-of-type(5) .index-card__item')
                ->assertPathIs('/items/6')
                ->press('購入手続きへ')
                ->assertPathIs('/purchase/6')
                ->select('#purchase-method-select', 'コンビニ払い')
                ->pause(500)
                ->assertSeeIn('#display-purchase-method', 'コンビニ払い')
                ->press('変更する')
                ->assertPathIs('/purchase/address/6')
                ->type('zipcode', '683-0937')
                ->type('address', '鳥取県米子市角盤町３－１０')
                ->type('building', 'ハイツ青山')
                ->click('.address-form__btn')
                ->assertPathIs('/purchase/address/6')
                ->assertSee('683-0937')
                ->assertSee('鳥取県米子市角盤町３－１０')
                ->assertSee('ハイツ青山');
        });
    }
}
