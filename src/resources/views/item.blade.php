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
<div class="product-all">
    <div class="product-detail">
        <div class="product__image-area">
            <div class="product__image-card">
                    <input type="image" src="{{ asset(  'storage/' . $item->image )}}" width="600px" height="600px" style="object-fit: cover;" alt="{{ $item->image}}"></input>
            </div>
        </div>
        <div class="product__description-area">
            <div class="product__description-card">
                <div class="product__description-card-title">
                    <div class="item-card__title">
                        <p class="item-card__title-name"> {{ $item->name }}</p>
                        <p class="item-card__title-brand">{{ $item->brand }}</p>
                        <p class="item-card__title-price">￥ <span> {{number_format($item->price)}} </span>（税込み）</p>
                        <div class="item-card__actions">
                            <div class="item-card__nice">
                                <div class="item-card__nice-icon">
                                </div>
                                <div class="item-card__nice-count">
                                    3
                                </div>
                            </div>
                            <div class="item-card__comment">
                                <div class="item-card__comment-icon">
                                </div>
                                <div class="item-card__comment-count">
                                    1
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="item__purchase-area">
                        <button class="item__purchase-btn">購入手続きへ</button>
                    </div>
                    <div class="item__description-area">
                        <div class="item__description-title">
                            商品説明
                        </div>
                        <div class="item__description">{{ $item->description}}</div>
                    </div>
                    <div class="item__infomation">
                        <div class="item__information-title">
                            商品の情報
                        </div>
                        <div class="item__information-category-title">
                            カテゴリー
                            <div class="item__information-categories">
                                @foreach($categories as $category)
                                <div class="item__information-category">{{ $category->name}}</div>
                                @endforeach
                            </div>
</div>
                            <div class="item__information-condition">
                                @php
                                switch($item->condition) {
                                case 1: $condition='良好'; break;
                                case 2: $condition='目立った傷や汚れなし'; break;
                                case 3: $condition='やや傷や汚れあり'; break;
                                case 4: $condition='状態が悪い'; break;
                                }
                                @endphp
                                商品の状態<span>{{ $condition }}</span>
                            </div>

                        </div>
                        <div class="item__comments">
                            @php
                            $count = 0;
                            @endphp
                            <div class="item__comments-title">{{ 'コメント(' .  $count .')'}}</div>
                            <div class="item__comments-list">
                                @foreach($comments as $comment)
                                <!-- $comment->user_id からuser,user->profile,profile->image and user->name 取得-->
                                <div class="item__comments-content">
                                    @if (!empty($comment))
                                    {{ $comment->pivot->comment }}
                                    @endif
                                </div>
                                @endforeach
                            </div>
                            <div class="item__comments-input">
                                <form action="/mypage/comment" class="form">
                                    <div class="item__comments-input-title">商品へのコメント</div>
                                    <textarea name="comment" id="" class="item__comments-input-text"></textarea>
                                    <button class="item__comments-btn">
                                        <div>コメントを送信する</div>
                                    </button>
                                </form>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="{{ asset('/js/item.js') }}"></script>
    @endsection