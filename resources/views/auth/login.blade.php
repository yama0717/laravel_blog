@extends('layouts.not_logged_in')

@section('content')
<div class="login">
    <h1 class="login_h1">ログイン</h1>
    
    <form method="post" action="{{ route('login') }}" class="login_menu">
        @csrf
        <!--<div>-->
        <!--    <label>-->
        <!--        メールアドレス:-->
        <!--        <input type="email" name="email" class="login_form">-->
        <!--    </label>-->
        <!--</div>-->
        <div>
            <label>
                メールアドレス:
                <input type="email" name="email" class="login_form">
            </label>
        </div>
        <div>
            <label>
                パスワード:
                <input type="password" name="password" class="login_form">
            </label>
        </div>
        
        <input type="submit" value="ログイン" class="login_btn">
    </form>
</div>
@endsection