@extends('layouts.logged_in')
 
@section('title', $title)
 
@section('content')

  <div class="main_content">
    <h1 class="main_title">{{ $title }}</h1>
    <h2 class="new_post_btn"><a href="{{ route('posts.create') }}">新規投稿</a></h2>
    
    <ul>
      <div class="main_body">
        @forelse($posts as $post)
        @if($post->user_id === Auth::user()->id)
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
          @endif
        @empty
          投稿がありません
          </li>
        @endforelse
      </div>
    </ul>
  </div>
@endsection