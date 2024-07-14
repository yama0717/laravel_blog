@extends('layouts.logged_in')
 
@section('title', $title)
 
@section('content')
  <div class="main_content">
    
  <h1 class="show_title">{{ $title }}</h1>
  
    @if(!empty($user))
      <ul class="show_body">
          <li>ユーザー名</li>
          <li>{{ $user->name }}</li>
          
          <!--自分の画面にはボタンを表示させない-->
          <li>
            @if($user->id !== Auth::user()->id)
            @if(Auth::user()->isFollowing($user))
              <form method="post" action="{{ secure_url(route('follows.destroy', $user))}}" class="follow">
                @csrf
                @method('delete')
                <input type="submit" value="フォロー解除">
              </form>
            @else
              <form method="post" action="{{ route('follows.store') }}" class="follow">
                @csrf
                <input type="hidden" name="follow_id" value="{{ $user->id }}">
                <input type="submit" value="フォロー">
              </form>
            @endif
            @endif
          </li>
      </ul>
      
      <ul>
          <li class="show_body">ユーザーの投稿</li>
          <div class="main_body">
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
                {!! nl2br(e($post->body)) !!}
              </div>
            @empty
              <p class="none_post">投稿がありません</p>
              </li>
            @endforelse
      </ul>
    @else
      <p>ユーザーが見つかりません</p>
    @endif
  </div>

@endsection