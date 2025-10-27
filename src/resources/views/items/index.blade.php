@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/index.css') }}" />
<meta name="viewport" content="width=device-width, initial-scale=1.0">
@endsection

@section('link')
<div class="header__search">
    <form action="/search" method="post">
        @csrf
        <input class="header-form__search" type="search" id="main-search" name="itemname" form="searchRecommend" placeholder="    なにをお探しですか？">
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
<div class="index__alert">
    @if(session('message'))
    <div class="index__alert--success">
        {{ session('message') }}
    </div>
    @endif
    @if($errors->any())
    <div class="index__alert--danger">
        <ul>
            @foreach($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif
</div>

<div class="index__list">
    <div class="index__tab">
        <form action="/" method="get" id="searchRecommend">
            <div>
                <input type="submit" value="おすすめ" class="index__tab-item" style={{ $ismylist ? 'color:#5F5F5F;' : 'color:#FF0000;' }}>
            </div>
        </form>
        <form action="/mylist" method="get" id="searchMylist">
            <div>
                <input type="hidden" id="hidden-search" name="itemname">
                <input type="submit" value="マイリスト" onclick="copySearchValue()" class="index__tab-item" style={{ $ismylist ? "color:#FF0000;" : "color:#5F5F5F;"}} >
            </div>
        </form>
    </div>
</div>
<hr color="#5F5F5F" size="2px" width="1510px">
<div class="index__content">
    <div class="index-main">
        <div class="index-card__frame">
            @if (!empty($items))
            @foreach($items as $item)
            <div class="index-card__list">
                <a href="/items/{{ $item->id}}" class="item-card">
                <div class="index-card__item">
                    <div class="index-card__image">
                        <input type="image" src="{{ asset(  'storage/' . $item->image )}}" width="290px" height="282px" style="object-fit: cover;" alt="{{ $item->image}}"></input>
                    </div>
                    <div class="index-card__title">
                        <span class="index-cart__title-name"> {{ $item->name }}</span>
                        @if (count($item->buyUsers()->get()) > 0)
                        <span class="index-card__title-sold">Sold</span>
                        @endif
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