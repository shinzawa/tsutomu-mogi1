@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/profile.css')}}">
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
        <a href="/sell" class="header__link-sell">出品</a>
    </div>
</div>
@endsection

@section('content')
<div class="profile-form">
    <h2 class="profile-form__heading content__heading">プロフィール設定</h2>
    <div class="profile-form__inner">
        <form action="/profile" method="post" enctype="mutipart/form-data">
            @csrf
            <div class="profile-form__group-image">
                <div>
                    <image src="{{ asset(  'storage/' . request('image') )}}" width="150px" height="150px" style="object-fit:cover;display:none;border-radius:50%;" alt="{{ request('image')}}" id="preview"></image>
                </div>

                <div class="profile-card__image" id="dummy"></div>
                <div class="profile-card__image-name">
                    <label for="image">
                        <div class="profile-form__imagefile">
                            画像を選択する
                        </div>
                        <span class="profile-form__filename" id="fileNameDisplay"></span>
                        <input class="profile-form__input-file" type="file" name="image" id="image" accept="image/png,image/jpeg" onchange="previewFile(this);" style="display:none">
                    </label>
                </div>

                <p class="profile-form__error-message">
                    @error('image')
                    {{ $message }}
                    @enderror
                </p>
            </div>
            <div class="profile-form__group profile-form__group-name">
                <label class="profile-form__label" for="name">
                    ユーザー名
                </label>

                <input class="profile-form__input" type="text" name="name" id="name">

                <div class="profile-form__error-message">
                    @error('name')
                    {{$errors('name')}}
                    @enderror
                </div>
            </div>

            <div class="profile-form__group">
                <label class="profile-form__label" for="zipcode">
                    郵便番号
                </label>
                <div class="profile-form__zipcode-inputs">
                    <input class="profile-form__input profile-form__zipcode-input" type="zipcode" name="zipcode" id="zipcode">
                </div>
                <p class="profile-form__error-message">
                    @error('zipcode')
                    {{ $message }}
                    @enderror
                </p>
            </div>

            <div class="profile-form__group">
                <label class="profile-form__label" for="address">
                    住所
                </label>
                <input class="profile-form__input" type="text" name="address" id="address">
                <p class="profile-form__error-message">
                    @error('address')
                    {{ $message }}
                    @enderror
                </p>
            </div>

            <div class="profile-form__group">
                <label class="profile-form__label" for="building">建物名</label>
                <input class="profile-form__input" type="text" name="building" id="building">
            </div>
            <input class="profile-form__btn btn" type="submit" value="更新する">
        </form>
    </div>
</div>
<script src="{{ asset('/js/main.js') }}"></script>
@endsection