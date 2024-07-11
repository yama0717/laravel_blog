@extends('layouts.logged_in')
 
@section('title', $title)
 
@section('content')
    
  <div class="main_content">
    
    <h1 class="main_title">{{ $title }}</h1>
    <div class="main_top">
      
      <div class="keyword">
        <form action="{{ route('posts.index') }}" method="get">
          @csrf
          <input type="text" name="keyword" value="{{$keyword}}" class="keyword_form">
          <input type="submit"value="検索" class="keyword_btn">
        </form>
      </div>
      
    <p class="greeting">{{ Auth::user()->name }}さん、こんにちは！</p>
    <h2>おすすめユーザー</h2>
    <ul class="unfollows">
      @forelse($unfollows as $unfollow)
        <li><a href="{{ route('users.show', $unfollow) }}">{{ $unfollow->name }}</a></li>
      @empty
        <li>他のユーザーが存在しません</li>
      @endforelse
    
    </ul>
    </div>
    <h3 class="new_post_btn"><a href="{{ route('posts.create') }}">新規投稿</a></h2>
    
    <div class="main_body">
      <ul>
        @forelse($posts as $post)
          <li class="post_body">
            <div>
              <div class="post_body_top">
              {{ $post->user->name }}  :
              {{ $post->title }}  :
              {{ $post->created_at }}
              </div>
            @if($post->user_id === Auth::user()->id)
              <div class="post_menu">
                <div class="edit_btn">
                  <a href="{{ route('posts.edit', $post) }}">編集</a>
                </div>
                <div class="delete_btn">
                  <form method="post" class="delete" action="{{ route('posts.destroy', $post) }}">
                    @csrf
                    @method('delete')
                    <input type="submit" value="削除">
                  </form>
                </div>
              </div>
            </div>
            @endif
          <div class="post_footer">
            {{ $post->body }}
          </div>
        @empty
          <p class="none_post">投稿がありません</p>
          </li>
        @endforelse
      </ul>
    </div>
  </div>


  
@endsection