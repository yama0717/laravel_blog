@extends('layouts.logged_in')
 
@section('title', $title)
 
@section('content')
<div class="main_content">
  
  <h1 class="follower_title">{{ $title }}</h1>
  
  <p class="follower_count">フォロワー: {{ $count }}</P>
  
     <ul class="follower">
        @forelse($followers as $follower)
        
          <a href="{{ route('users.show', $follower) }}">{{ $follower->name }}</a>
          
          <li>
            @if($follower->id !== Auth::user()->id)
            @if(Auth::user()->isFollowing($follower))
              <form method="post" action="{{ secure_url(route('follows.destroy', $follower))}}" class="follow_cancellation_btn">
                @csrf
                @method('delete')
                <input type="submit" value="フォロー解除">
              </form>
            @else
              <form method="post" action="{{ route('follows.store') }}" class="follow_btn">
                @csrf
                <input type="hidden" name="follow_id" value="{{ $follower->id }}">
                <input type="submit" value="フォロー">
              </form>
            @endif
            @endif
          @empty
            <li>フォロワーはいません</li>
          @endforelse
      </ul>
</div>
@endsection