@extends('layouts.default')
 
@section('header')
<header>
    <ul class="header_left">
        <li>マイブログ</li>
    </ul>
    <ul class="header_right">
        <li class="header_btn">
          <a href="{{ route('register') }}">
            サインアップ
          </a>
        </li>
        <li>
          <a href="{{ route('login') }}">
            ログイン
          </a>
        </li>
    </ul>
</header>
<div class="sign_up">
</div>
@endsection