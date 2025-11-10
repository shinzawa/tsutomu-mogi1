@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/test.css') }}" />
<meta name="viewport" content="width=device-width, initial-scale=1.0">
@endsection

@section('link')
<div class="header__search">
    <form action="/search" method="post" novalidate>
        @csrf
        <input class="header-form__search" type="text" name="text" placeholder="    なにをお探しですか？">
    </form>
</div>
<div class="header__link">
    @if (Auth::check())
    <form action="{{ route('logout')}}" method="post" novalidate>
        @csrf
        <input class="header-form__link" type="submit" value="ログアウト">
    </form>
    @else
    <form action="/login" method="get" novalidate>
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

<form action="{{ url('mail') }}" method='POST'>
    @csrf
    <div class="form-group">

        <p>名前</p>
        <input type="text" name="name" value="{{ old('name') }}" class="form-control">
        @if ($errors->has('name'))
        <p class="bg-danger">{{ $errors->first('name') }}</p>
        @endif

        <p>メッセージ</p>
        <input type="text" name="message" value="{{ old('message') }}" class="form-control">
        @if ($errors->has('message'))
        <p class="bg-danger">{{ $errors->first('message') }}</p>
        @endif

        <p><input type="submit" value="送信" class="btn"></p>

    </div>
</form>


@if (Session::has('succsss'))
<div>
    <p class="bg-warning text-center">{{ Session::get('success')}}</p>
</div>
@endif

@endsection