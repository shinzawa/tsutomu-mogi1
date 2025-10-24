@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/mypage/index.css') }}" />
<meta name="viewport" content="width=device-width, initial-scale=1.0">
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
<div class="profile__frame">
    <div class="profile__card">
        <div class="profile__group-image">
            <image src="{{ asset(  'storage/' . $profile->image )}}" width="150px" height="150px" style="object-fit:cover;border-radius:50%;" alt="{{ $profile->image}}" id="preview"></image>
        </div>
        <div class="profile__group-name">
            <p class="profile__name">
                {{$profile->name }}
            </p>
        </div>
    </div>
    <div class="profile__action">
        <form action="/mypage/profile" class="profile-form" method="get">
            <button class="profile__action-btn">
                <div> プロフィールを編集する</div>
            </button>
        </form>
    </div>
</div>

<div class="index__list">
    <div class="index__tab">
        @php
        $isbuy=1;
        @endphp
        @if ($isbuy)
        <div class="index__tab-item" styel="color:#5F5F5F;">
            出品した商品
        </div>
        <div class="index__tab-item" style="color:#FF0000;">
            購入した商品
        </div>
        @else
        <div class="index__tab-item" style="color:#FF0000;">
            出品した商品
        </div>
        <div class="index__tab-item" styel="color:#5F5F5F;">
            購入した商品
        </div>
        @endif
    </div>
</div>
<hr color="#5F5F5F" size="2px" width="1510px">
<div class="index__content">
    <div class="index-main">
        <div class="index-card__frame">
            @if($isbuy)
            @foreach($buyItems as $item)
            <div class="index-card__list">
                <a href="/items/{{ $item->id}}" class="item-card">
                    <div class="index-card__item">
                        <div class="index-card__image">
                            <input type="image" src="{{ asset(  'storage/' . $item->image )}}" width="290px" height="282px" style="object-fit: cover;" alt="{{ $item->image}}"></input>
                        </div>
                        <div class="index-card__title">
                            <span class="index-cart__title-name"> {{ $item->name }}</span>
                            <span class="index-card__title-sold">Sold</span>
                        </div>
                    </div>
                </a>
            </div>
            @endforeach
            @else
            @foreach($exhibitItems as $item)
            <div class="index-card__list">
                <a href="/items/{{ $item->id}}" class="item-card">
                    <div class="index-card__item">
                        <div class="index-card__image">
                            <input type="image" src="{{ asset(  'storage/' . $item->image )}}" width="290px" height="282px" style="object-fit: cover;" alt="{{ $item->image}}"></input>
                        </div>
                        <div class="index-card__title">
                            <span class="index-cart__title-name"> {{ $item->name }}</span>
                            <span class="index-card__title-sold">Sold</span>
                        </div>
                    </div>
                </a>
            </div>
            @endforeach
            @endif
        </div>
    </div>
</div>
<script src="{{ asset('/js/index.js') }}"></script>
@endsection