@extends('layouts.logged_in')

@section('title', $title)

@section('content')
<div class="main_content">
  <h1 class="main_title">{{ $title }}</h1>
  <h2 class="edit_h2">現在の画像</h2>
  <div class="profile_body">
    @if($user !== null)
    @if($user->id === Auth::user()->id)
    <div class="profile_image">
        @if($user->image !== '')
          <img src="{{ asset('storage/' . $user->image) }}"
        @else
          <img src="{{ asset('images/no_image.png') }}">
        @endif
    </div>
    
    <div class="profile_form">
      <form 
        method="post" 
        action="{{ route('users.update_image', $user) }}"
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
    </div>
    @endif
    @endif
  </div>
</div>
@endsection