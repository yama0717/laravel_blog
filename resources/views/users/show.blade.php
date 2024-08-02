@extends('layouts.logged_in')
 
@section('title', $title)
 
@section('content')
  <div class="main_content">
    
  <h1 class="show_title">{{ $title }}</h1>
  
    <p class="user_search"><a href="{{ route('users.search') }}">ユーザーを検索</a></p>
    
    @if(!empty($user))
      <ul class="show_body">
          <li>ユーザー名</li>
          <li>{{ $user->name }}</li>
          
          <!--自分の画面にはボタンを表示させない-->
          <li>
            @if($user->id === Auth::user()->id) 
              <a href="{{ route('users.edit') }}">編集</a>
            @endif
          
            @if($user->id !== Auth::user()->id)
            @if(Auth::user()->isFollowing($user))
              <form method="post" action="{{ route('follows.destroy', $user)}}" class="follow_cancellation_btn">
                @csrf
                @method('delete')
                <input type="submit" value="フォロー解除" >
              </form>
            @else
              <form method="post" action="{{ route('follows.store') }}" class="follow_btn">
                @csrf
                <input type="hidden" name="follow_id" value="{{ $user->id }}">
                <input type="submit" value="フォロー">
              </form>
            @endif
            @endif
          </li>
      </ul>
      <div>
        <ul class="show_body">
          <li>
            @if($user->image !== '')
              <img src="{{ asset('storage/' . $user->image) }}">
            @else
              <img src="{{ asset('images/no_image.png') }}">
            @endif
          </li>
          <li>
            @if($user->id === Auth::user()->id) 
              <a href="{{ route('users.edit_image') }}">画像を変更</a>
            @endif
          </li>
          <li>プロフィール</li>
          @if($user->profile)
            <li>{{ $user->profile }}</li>
          @else
            <li>プロフィールが設定されていません</li>
          @endif
        </ul>
      </div>
      
      <ul>
          <li class="show_body">{{ $user->name }}さんの投稿</li>
          <div class="main_body">
            @forelse($posts as $post)
              <li class="post_body">
                <div>
                  <div class="post_body_top">
                  投稿者:{{ $post->user->name }}  :
                  {{ $post->title }}  :
                  {{ $post->created_at }}
                  </div>
                  <div>
                  @if($post->isLikedBy($myuser))
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
                @endif
              </div>
              <div class="post_footer">
                {!! nl2br(e($post->body)) !!}
              </div>
              
              <div class="post_comments">
                <span>コメント</span>
                <ul >
                  @forelse($post->comments as $comment)
                    <li>
                      投稿者:<a href="{{ route('users.show', $comment->user_id) }}"> {{ $comment->user->name }} </a>  :{{ $comment->created_at }}
                    </li>  
                    <li>
                      {{ $comment->body }}
                    </li>
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
    @else
      <p class="none_post">ユーザーが見つかりません</p>
    @endif
  </div>

@endsection