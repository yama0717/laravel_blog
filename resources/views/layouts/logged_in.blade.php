@extends('layouts.default')
 
@section('header')
<header class="header">
    
    <ul class="header_left">
      <li class="header_title">
        マイブログ
      </li>
      <li>
        <a href="{{ route('posts.index') }}">
          投稿一覧
        </a>
      </li>
      </ul>
      <ul class="header_right">
        <li>
          <a href="{{ route('posts.create') }}">
            新規投稿
          </a>
        </li>
        <li>
          <a href="{{ route('posts.edit_index') }}">
            投稿編集
          </a>
        </li>
        <li>
          <div class="logout_btn">
            <form action="{{ route('logout') }}" method="post">
              @csrf
              <input type="submit" value="ログアウト">
            </form>
          </div>
        </li>
    </ul>
  
</header>
@endsection