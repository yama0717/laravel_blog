@extends('layouts.logged_in')
 
@section('content')
<div class="main_content">
    <h1 class="main_title">{{ $title }}</h1>
    <h2 class="edit_h2">現在の画像</h2>
    <div  class="edit_image">
        @if($post->image !== null)
            <img src="{{ \Storage::url($post->image) }}">
        @else
            <p class="edit_image">画像はありません。</p>
        @endif
    </div>
    <div class="image_form">
        <form
            method="POST"
            action="{{ route('posts.update_image', $post) }}"
            enctype="multipart/form-data"
        >
            @csrf
            @method('patch')
            <div>
                <label>
                    画像を選択:
                    <input type="file" name="image">
                </label>
            </div>
            <input type="submit" value="更新" class="edit_btn">
        </form>
          <form method="post" class="delete" action="{{ route('posts.destroy_image', $post) }}">
        @csrf
        @method('delete')
        <input type="submit" value="削除" class="delete_btn">
      </form>
  </div>
</div>
@endsection