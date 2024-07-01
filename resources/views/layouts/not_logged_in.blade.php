@extends('layouts.default')
 
@section('header')
<div class="sign_up">
<h1 class="login_title">マイブログ</h1>
<header class=>
    <ul class="header_nav">
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
</div>
@endsection