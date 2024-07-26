@extends('layouts.logged_in')
 
@section('title', $title)
 
@section('content')
    <div class="main_content">
    <h1 class="edit_title">{{ $title }}</h1>
      <form method="post" action="{{ route('posts.update', $post) }}" class="edit_form" enctype="multipart/form-data">
          @csrf
          @method('patch')
          <div class="form_header">
              <label>
                  タイトル:
                  <input type="text" name="title" value="{{ $post->title }}" class="title_form">
              </label>
          </div>
          <div class="image">
            @if($post->image !== null)
              <img src="{{ \Storage::url($post->image) }}">
            @else
              <p></p>
            @endif
            <a href="{{ route('posts.edit_image', $post) }}">画像を変更</a>
          </div>
          <div class="form_main">
              <label>
                  <div class="form_main_body">
                    本文：
                  </div>
                  <textarea name="body" rows="8" cols="60">{{ $post->body }}</textarea>
              </label>
          </div>
          <input type="submit" value="更新" class="edit_btn">
      </form>
    </div>
@endsection