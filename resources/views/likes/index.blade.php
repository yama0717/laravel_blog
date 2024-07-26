@extends('layouts.logged_in')

@section('title', $title)

@section('content')
  <div class="main_content">
    <div class="main_body">
      
    <h1 class="like_title">{{ $title }}</h1>
  
      <ul>
        @forelse($like_posts as $post)
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
                    <input type="submit" value="削除" class="de"delete_btn>
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
                <li><a href="{{ route('users.show', $comment->user_id) }}">投稿者: {{ $comment->user->name }}   :{{ $comment->created_at }}</a></li>
                <li>{{ $comment->body }}</li>
                <li>
                  @if($comment->user_id === Auth::user()->id)
                    <form method="post" action="{{ route('comments.destroy', $comment) }}">
                      @csrf
                      @method('delete')
                      <input type="submit" value="削除" class="delete_btn">
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
          <p class="none_post">いいねがありません</p>
          </li>
        @endforelse
      </ul>
    </div>
  </div>
@endsection