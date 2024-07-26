@extends('layouts.logged_in')
 
@section('title', $title)
 
@section('content')
  <div class="main_content">
    
    <h1 class="follow_title">{{ $title }}</h1>
    
    <p class="follow_count">フォロー: {{ $count }}</P>
    
      <ul class="follow">
      @forelse($follow_users as $follow_user)
      
        
        <li>
          <a href="{{ route('users.show', $follow_user) }}">{{ $follow_user->name }}</a>
        </li>
        <li>
          <form method="post" action="{{ route('follows.destroy', $follow_user) }}" class="follow_cancellation_btn">
          @csrf
          @method('delete')
          <input type="submit" value="フォロー解除">
          </form>
        </li>
      @empty
        <li>フォローしているユーザーはいません</li>
      @endforelse
    </ul>
  </div>
@endsection