@extends('layouts.not_logged_in')
 
@section('content')
  <h1 class="register_h1">サインアップ</h1>
 
  <form method="POST" action="{{ route('register') }}" class="register_menu">
    @csrf
    <div>
      <label>
        ユーザー名:
        <input type="text" name="name" class="register_form">
      </label>
    </div>
 
    <div>
      <label>
        メールアドレス:
        <input type="email" name="email" class="register_form">
      </label>
    </div>
 
    <div>
      <label>
        パスワード:
        <input type="password" name="password" class="register_form">
      </label>
    </div>
 
    <div>
      <label>
        パスワード（確認用）:
        <input type="password" name="password_confirmation" class="register_form">
      </label>
    </div>
 
    <div>
      <input type="submit" value="登録" class="register_btn">
    </div>
  </form>
@endsection