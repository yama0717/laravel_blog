@extends('layouts.logged_in')
 
@section('title', $title)
 
@section('content')
  <div class="main_content">
    
  <h1 class="show_title">{{ $title }}</h1>
  
    <div class="keyword">
      <form action="{{ route('users.search') }}" method="get">
        @csrf
        <input type="text" name="keyword" value="{{$keyword}}" class="keyword_form" placeholder="ユーザーを検索" >
        <input type="submit"value="検索" class="keyword_btn">
      </form>
    </div>
    
    <ul>
      @forelse($users as $user)
        <li><a href="{{ route('users.show', $user) }}">{{ $user->name }}</a></li>
      @empty
        <li>ユーザーがいません</li>
      @endforelse
    </ul> 

@endsection



