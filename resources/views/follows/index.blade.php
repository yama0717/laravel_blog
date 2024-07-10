@extends('layouts.logged_in')
 
@section('title', $title)
 
@section('content')
  <h1>{{ $title }}</h1>
    <ul>
    @forelse($follow_users as $follow_user)
      <li>
        <a href="{{ route('users.show', $follow_user) }}">{{ $follow_user->name }}</a>
        <form method="post" action="{{ route('follows.destroy', $follow_user) }}">
        @csrf
        @method('delete')
        <input type="submit" value="フォロー解除">
        </form>
      </li>
    @empty
      <li>フォローしているユーザーはいません</li>
    @endforelse
  </ul>
@endsection