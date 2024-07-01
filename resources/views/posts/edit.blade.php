@extends('layouts.logged_in')
 
@section('title', $title)
 
@section('content')
  <h1 class="edit_title">{{ $title }}</h1>
  <div class="main_content">
    <form method="post" action="{{ route('posts.update', $post) }}" class="edit_form">
        @csrf
        @method('patch')
        <div class="form_header">
            <label>
                タイトル:
                <input type="text" name="title" value="{{ $post->title }}" class="title_form">
            </label>
        </div>
        <div class="form_main">
            <label>
                <div class="form_main_body">
                  本文：
                </div>
                <textarea name="body" rows="8" cols="60">{{ $post->body }}</textarea>
            </label>
        </div>
        <input type="submit" value="更新" class="create_btn">
    </form>
  </div>
@endsection