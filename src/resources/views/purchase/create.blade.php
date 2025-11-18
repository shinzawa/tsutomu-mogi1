@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/header.css') }}" />
<link rel="stylesheet" href="{{ asset('css/purchase.css') }}" />
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
        <a href="/exhibit" class="header__link-sell">出品</a>
    </div>
</div>
@endsection

@section('content')
<form action="/purchase/{{$item_id}}" class="purchase-form" method="post" id="purchase" novalidation>
    @csrf
    <div class="purchase-upper">
        <div class="purchase-all">
            <div class="purchase-left-area">
                <div class="product-detail">
                    <div class="product__image-area">
                        <div class="product__image-card">
                            <input type="image" src="{{ asset(  'storage/' . $purchase->image )}}" width="178px" height="178px" style="object-fit: cover;" alt="{{ $purchase->image}}"></input>
                        </div>
                    </div>
                    <div class="product__description-card">
                        <div class="purchase-card__title">
                            <p class="purchase-card__title-name"> {{ $purchase->name }}</p>
                            <p class="purchase-card__title-price">￥ <span> {{number_format($purchase->price)}} </span></p>
                        </div>
                    </div>
                </div>
                <hr class="product-detail__title" size="1px" width="100%" color="#000000">
                <div class="purchase-method">
                    <div class="purchase-method-card-title">
                        <p class="purchase-method-title">支払方法</p>
                    </div>
                    <div class="purchase-method-card-select">
                        <div>
                            <div class="purchase-method-select">
                                @isset($purchaseMethod)
                                <select name="purchase-method" id="purchase-method-select">
                                    <option disable @if( $purchaseMethod=='' ) selected @endif value=""> &nbsp;&nbsp;選択して下さい</option>
                                    <option value="コンビニ払い" @if( $purchaseMethod=='コンビニ払い' ) selected @endif>コンビニ払い</option>
                                    <option value="カード支払い" @if( $purchaseMethod=='カード支払い' ) selected @endif>カード支払い</option>
                                </select>
                                @else
                                <select name="purchase-method" id="purchase-method-select">
                                    <option disable selected value=""> &nbsp;&nbsp;選択して下さい</option>
                                    <option value="コンビニ払い">コンビニ払い</option>
                                    <option value="カード支払い">カード支払い</option>
                                </select>
                                @endisset
                            </div>
                            <div class="form__error">
                                @error('purchase-method')
                                {{ $message }}
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>
                <hr class="purchase-action__title" size="1px" width="100%" color="#000000">
            </div>
            <div class="purchase-right-area">
                <div class="purchase-card-confirm">
                    <div class="purchase-price-card">
                        <div class="purchase-price-card-title">
                            <div class="purchase-price-title">商品代金</div>
                        </div>
                        <div class="purchase-price-card-title">
                            <div>
                                <p class="purchase-price-card-title-price">￥ <span> {{number_format($purchase->price)}} </span></p>
                            </div>
                        </div>
                    </div>
                    <div class="purchase-method__card">
                        <div class="purchase-method__card-title">
                            <div class="purchase-method__card-title2">支払方法</div>
                        </div>
                        <div class="purchase-method__card-title">
                            <div>
                                <p class="purchase-method__card-title-method">
                                    <span id="display-purchase-method">選択して下さい</span>
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="purchase-action">
                        <div class="item__purchase-area">
                            <input type="hidden" name="name" value="{{ $purchase->name}}">
                            <input type="hidden" name="price" value="{{ $purchase->price}}">
                            <button class="item__purchase-btn">購入する</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>
<div class="purchase-lower">
    <div class="purchase-lower-up">
        <div class="purchase-lower-up-left">
            <form action="/purchase/{{ $item_id }}" class="purchase-form-lower" method="post" novalidation>
                @csrf
                <div class="purchase-address__card">
                    <div class="purchase-address">
                        <div class="purchase-address-card-title">
                            <p class="purchase-address-title">配送先</p>

                        </div>
                        <div class="purchase-address-card">
                            @if (!empty($newaddress))
                            <div>
                                <input type="hidden" name="zipcode" value="{{ $newaddress['zipcode'] }}" form="purchase">
                                <input type="hidden" name="address" value="{{ $newaddress['address'] }}" form="purchase">
                                <input type="hidden" name="building" value="{{ $newaddress['building'] }}" form="purchase">
                                <p>{{ $newaddress['zipcode'] }}</p>
                                <p><span>{{$newaddress['address']}}</span> <span>{{$newaddress['building']}}</span> </p>
                            </div>
                            @else
                            <div>
                                <input type="hidden" name="zipcode" value="{{$profile->zipcode}}" form="purchase">
                                <input type="hidden" name="address" value="{{$profile->address}}" form="purchase">
                                <input type="hidden" name="building" value="{{$profile->building}}" form="purchase">
                                <p>{{$profile->zipcode}}</p>
                                <p><span>{{$profile->address}}</span> <span>{{$profile->building}}</span> </p>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
            </form>
        </div>
        <div class="purchase-lower-up-right">
            <form action="/purchase/address/{{ $purchase->id }}" method="get" novalidation>
                <input type="hidden" name="purchaseMethod" id="purchaseMethod"></input>
                <button class="purchase-address-change-btn">変更する</button>
            </form>
        </div>
    </div>
    <hr class="purchase-action__title" size="1px" width="100%" color="#000000">
</div>

<script src="{{ asset('/js/purchase.js') }}"></script>
@endsection