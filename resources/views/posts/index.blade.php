@extends('layouts.logged_in')
 
@section('title', $title)
 
@section('content')
    
  <div class="main_content">
    
    <h1 class="main_title">{{ $title }}</h1>
    <div class="main_top">
      
      <div class="keyword">
        <form action="{{ route('posts.index') }}" method="get">
          @csrf
          <input type="text" name="keyword" value="{{$keyword}}" class="keyword_form" placeholder="投稿を検索" >
          <input type="submit"value="検索" class="keyword_btn">
        </form>
      </div>
      
    <p class="greeting"><a href="{{ route('users.show', $user) }}">{{ Auth::user()->name }}さん、こんにちは！</a></p>
    <h2 class="greeting">おすすめユーザー</h2>
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
              投稿者:<a href="{{ route('users.show', $post->user->id)}}">{{ $post->user->name }}</a>  :
              {{ $post->title }}  :
              {{ $post->created_at }}
              </div>
              
              <div>
              @if($post->isLikedBy($user))
                <form method="post" action="{{ route('posts.toggle_like_delete', $post)}} ">
                  @csrf
                  @method('delete')
                  <input type="submit" value="いいね取り消し" class="unlike">
                </form>
              @else
                <form method="post" action="{{ route('posts.toggle_like', $post) }}">
                  @csrf
                  <input type="hidden" name="post_id" value="{{ $post->id }}">
                  <input type="submit" value="いいね" class="like">
                </form>
              @endif
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
          <div class="post_image">
            @if($post->image !== null)
              <img src="{{ asset('storage/' . $post->image) }}">
            @else
              <p></p>
            @endif
          </div>
          <div class="post_main_body">
            {!! nl2br(e($post->body)) !!}
          </div>
          <div class="post_comments">
            <span>コメント</span>
            <ul>
              @forelse($post->comments as $comment)
                <li>投稿者:<a href="{{ route('users.show', $comment->user_id) }}"> {{ $comment->user->name }}   </a>:{{ $comment->created_at }}</li>
                <li>{{ $comment->body }}</li>
                <li>
                  @if($comment->user_id === Auth::user()->id)
                    <form method="post" action="{{ route('comments.destroy', $comment) }}">
                      @csrf
                      @method('delete')
                      <input type="submit" value="削除">
                    </form>
                  @endif
                </li>
              @empty
              @endforelse
            </ul>
            <form method="post" action="{{ route('comments.store') }}">
              @csrf
              <input type="hidden" name="post_id" value="{{ $post->id }}">
              <label>
                <input type="text" name="body" placeholder="コメントを入力してください" class="comment_form">
              </label>
              <input type="submit" value="送信" class="comment_btn">
            </form>
          </div>
        @empty
          <p class="none_post">投稿がありません</p>
          </li>
        @endforelse
      </ul>
    </div>
  </div>


  
@endsection