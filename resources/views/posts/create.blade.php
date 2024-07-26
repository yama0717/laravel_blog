@extends('layouts.logged_in')
 
@section('title', $title)
 
@section('content')
  <div class="create">
    <h1 class="create_title">{{ $title }}</h1>
    <form method="post" action="{{ route('posts.store') }}" enctype="multipart/form-data" class="create_form">
        @csrf
        <div class="form_header">
            <label>
              タイトル:
              <input type="text" name="title" class="title_form">
            </label>
        </div>
        <div>
          <label>
            画像:
            <input type="file" name="image">
          </label>
        </div>
        <div class="form_main">
            <label>
              <div class="form_main_body">
                本文:
              </div>
              <textarea name="body" rows="8" cols="60"></textarea>
            </label>
        </div>
        
        <input type="submit" value="投稿" class="edit_btn">
    </form>
  </div>
@endsection