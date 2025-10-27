@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/address.css')}}">
@endsection

@section('link')
<div class="header__search">
    <form action="/search" method="post">
        @csrf
        <input class="header-form__search" type="text" name="text" placeholder="    なにをお探しですか？">
    </form>
</div>
<div class="header__link">
    @if (Auth::check())
    <form action="{{ route('logout')}}" method="post">
        @csrf
        <input class="header-form__link" type="submit" value="ログアウト">
    </form>
    @else
    <form action="/login" method="get">
        @csrf
        <input class="header-form__link" type="submit" value="ログイン">
    </form>
    @endif
    <a href="/mypage" class="header__link-mypage">マイページ</a>
    <div class="header__link-rect">
        <a href="/exhibit" class="header__link-sell">出品</a>
    </div>
</div>
@endsection

@section('content')
<div class="address-form">
    <h2 class="address-form__heading content__heading">住所の変更</h2>
    <div class="address-form__inner">
        <form action="/purchase/address" method="post" enctype="multipart/form-data">
            @csrf
            <div class="address-form__group">
                <label class="address-form__label" for="zipcode">
                    郵便番号
                </label>
                <div class="address-form__zipcode-inputs">
                    <input class="address-form__input address-form__zipcode-input" type="zipcode" name="zipcode" id="zipcode">
                </div>
                <p class="address-form__error-message">
                    @error('zipcode')
                    {{ $message }}
                    @enderror
                </p>
            </div>

            <div class="address-form__group">
                <label class="address-form__label" for="address">
                    住所
                </label>
                <input class="address-form__input" type="text" name="address" id="address">
                <p class="address-form__error-message">
                    @error('address')
                    {{ $message }}
                    @enderror
                </p>
            </div>

            <div class="address-form__group">
                <label class="address-form__label" for="building">建物名</label>
                <input class="address-form__input" type="text" name="building" id="building">
            </div>
            <input class="address-form__btn btn" type="submit" value="更新する">
        </form>
    </div>
</div>
<script src="{{ asset('/js/main.js') }}"></script>
@endsection