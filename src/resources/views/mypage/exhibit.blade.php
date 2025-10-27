@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/exhibit.css')}}">
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
<div class="exhibit-form">
    <div class="exhibit-form__area">
        <h2 class="exhibit-form__heading content__heading">商品の出品</h2>
        <div class="exhibit-form__inner">
            <form action="/exhibit" method="post" enctype="multipart/form-data">
                @csrf
                <div class="exhibit-card__image-title">
                    商品画像
                </div>
                <div class="exhibit-form__group-image">
                    <div>
                        <image src="{{ asset(  'storage/' . request('image') )}}" width="680px" height="150px" style="object-fit:cover;display:none;" alt="{{ request('image')}}" id="preview"></image>
                    </div>

                    <div class="exhibit-card__image" id="dummy"></div>
                    <div class="exhibit-card__image-name">
                        <label for="image">
                            <div class="exhibit-form__imagefile-parent">
                                <div class="exhibit-form__imagefile">
                                    画像を選択する
                                </div>
                            </div>
                            <span class="exhibit-form__filename" id="fileNameDisplay"></span>
                            <input class="exhibit-form__input-file" type="file" name="image" id="image" accept="image/png,image/jpeg" onchange="previewFile(this);" style="display:none">
                        </label>
                    </div>

                    <p class="exhibit-form__error-message">
                        @error('image')
                        {{ $message }}
                        @enderror
                    </p>
                </div>
                <div class="exhibit-card__item-detail">
                    <div class="exhibit-detail__title">
                        商品の詳細
                    </div>
                    <hr class="exhibit-detail__title" size="1px" width="680px" color="#5F5F5F">
                    <div class="exhibit-detail__category-area">
                        <p class="exhibit-detail__item-category-title">カテゴリー</p>
                        <div class="exhibit-detail__item-categories">
                            @foreach($categories as $category)
                            <span class="exhibit-detail__item-category">{{ $category->name}}</span>
                            @endforeach
                        </div>
                        <p class="exhibit-detail__item-condition-title">商品の状態</p>
                        <div class="exhibit-detail__item-condition">
                            <select name="condition">
                                <option disable selected value="">選択して下さい</option>
                                <option value="1">良好</option>
                                <option value="2">目立った傷や汚れなし</option>
                                <option value="3">やや傷や汚れあり</option>
                                <option value="4">状態が悪い</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="exhibit-form__item-name-card">
                    <div class="exhibit-detail__title">
                        商品名と詳細
                    </div>
                    <hr class="exhibit-detail__title" size="1px" width="680px" color="#5F5F5F">
                    <div class="exhibit-form__group exhibit-form__group-name">
                        <label class="exhibit-form__label" for="name">
                            商品名
                        </label>

                        <input class="exhibit-form__input" type="text" name="name" id="name">

                        <div class="exhibit-form__error-message">
                            @error('name')
                            {{$errors('name')}}
                            @enderror
                        </div>
                    </div>

                    <div class="exhibit-form__group">
                        <label class="exhibit-form__label" for="zipcode">
                            ブランド名
                        </label>
                        <div class="exhibit-form__inputs">
                            <input class="exhibit-form__input" type="zipcode" name="zipcode" id="zipcode">
                        </div>
                        <p class="exhibit-form__error-message">
                            @error('zipcode')
                            {{ $message }}
                            @enderror
                        </p>
                    </div>

                    <div class="exhibit-form__group">
                        <label class="exhibit-form__label" for="address">
                            商品の説明
                        </label>
                        <input class="exhibit-form__input-textarea" type="textarea" name="address" id="address">
                        <p class="exhibit-form__error-message">
                            @error('address')
                            {{ $message }}
                            @enderror
                        </p>
                    </div>

                    <div class="exhibit-form__group">
                        <label class="exhibit-form__label" for="building">
                            価格
                        </label>
                        <input class="exhibit-form__input" type="text" name="building" id="building">
                    </div>

                </div>
                <input class="exhibit-form__btn btn" type="submit" value="更新する">
            </form>
        </div>
    </div>
</div>
<script src="{{ asset('/js/main.js') }}"></script>
@endsection