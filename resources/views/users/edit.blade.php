@extends('layouts.logged_in')

@section('title', $title)

@section('content')
<div class="main_content">
  <h1 class="main_title">{{ $title }}</h1>
  
  <div class="profile_body">
    
  <a href="{{ route('users.show', \Auth::user()->id) }}">戻る</a>
  
  @if($user !== null)
  @if($user->id === Auth::user()->id)
    <form method="post" action="{{ route('users.update') }}">
        @csrf
        @method('patch')
        <div>
            <div>
                <label>
                    名前:
                    <input type="text" name="name" value="{{ $user->name }}" placeholder="名前を入力してください" class="name_form">
                </label>
            </div>
            <div>
                <label>
                    メールアドレス:
                    <input type="email" name="email" value="{{ $user->email }}" placeholder="メールアドレスを入力してください" class="email_form">
                </label>
            </div>
            <div>
                <label>
                    プロフィール:
                    <textarea type="text" name="profile" placeholder="" rows="6" cols="80">{{ $user->profile }}</textarea>
                </label>
            </div>
            <input type="submit" value="更新" class="edit_btn">
            
        </div>
    </form>
  </div>
  @endif
  @endif
</div>
@endsection