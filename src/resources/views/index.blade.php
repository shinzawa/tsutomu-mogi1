@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/item.css') }}" />
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
<div class="item__alert">
    @if(session('message'))
    <div class="item__alert--success">
        {{ session('message') }}
    </div>
    @endif
    @if($errors->any())
    <div class="item__alert--danger">
        <ul>
            @foreach($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif
</div>

<div class="item__content">
    <div class="item__tab">
        <div class="item__tab-item">
            <span>おすすめ</span>
        </div>
        <div class="item__tab-item">
            <span>マイリスト</span>
        </div>
    </div>
    <div class="item-main">

        <div class="item-card__frame">
            <div class="item-card__list">
                @foreach($items as $item)
                <a href="/items/{{ $item->id}}" class="item-card">
                    <div class="item-card__item">
                        <div class="item-card__image">
                            <input type="image" src="{{ asset(  'storage/' . $item->image )}}" width="374px" height="340px" style="object-fit: cover;" alt="{{ $item->image}}"></input>
                        </div>
                        <div class="item-card__title">
                            <span class="item-cart__title-name"> {{ $item->name }}</span>
                            <span class="item-card__title-sold"></span>
                        </div>
                    </div>
                </a>
                @endforeach

            </div>
        </div>
    </div>
</div>
<script src="{{ asset('/js/item.js') }}"></script>
@endsection