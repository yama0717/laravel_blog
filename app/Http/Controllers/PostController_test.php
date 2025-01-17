<?php

namespace App\Http\Controllers;
use App\Models\Post;
use App\Models\User;
use App\Http\Requests\PostRequest;

use Illuminate\Http\Request;

class PostController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = \Auth::user();
        // フォローしている人
        $follow_user_ids = $user->follow_users->pluck('id');
        // フォローしていない人
        // $unfollows = User::where('id' , '!=', $follow_user_ids)->latest()->limit(3);
        // $unfollows = User::whereNotIn('id' , $follow_user_ids)->latest()->limit(3);
        $unfollows = User::whereNotIn('id', $follow_user_ids)->latest()->limit(3);
        // dd($follow_user_ids);
        // dd(User::whereNotIn('id', $follow_user_ids)->toSql());
        $posts = $user->posts()->orWhereIn('user_id', $follow_user_ids )->latest()->get();
        return view ('posts.index', [
            'title' => '投稿一覧',
            'posts' => $posts,
            'recommended_users' => User::recommend($user->id)->get(),
            'unfollows' => $unfollows
        ]);
    }
    
    public function index_t()
    {
        $user = \Auth::user();
        // フォローしている人
        $follow_user_ids = $user->follow_users->pluck('id');
        // フォローしていない人
        // $unfollows = User::where('id' , '!=', $follow_user_ids)->latest()->limit(3);
        // $unfollows = User::whereNotIn('id' , $follow_user_ids)->latest()->limit(3);
        // $unfollows = User::whereNotIn('id', $follow_user_ids)->latest()->limit(3);

        // $unfollows = User::latest()->get();
        $unfollows = User::whereNotIn('id', $follow_user_ids)->latest()->limit(2)->get();
        // $unfollows = User::whereNotIn('id', $follow_user_ids)->latest()->get();
        // dd(User::whereNotIn('id', $follow_user_ids)->latest()->limit(2)->toSql());
        // dd($unfollows);

        // dd($follow_user_ids);
        // dd(User::whereNotIn('id', $follow_user_ids)->toSql());
        $posts = $user->posts()->orWhereIn('user_id', $follow_user_ids )->latest()->get();
        return view ('posts.index', [
            'title' => '投稿一覧',
            'posts' => $posts,
            'recommended_users' => User::recommend($user->id)->get(),
            'unfollows' => $unfollows
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view ('posts.create', [
            'title' => '新規投稿',
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(PostRequest $request)
    {
        Post::create([
            'user_id' => \Auth::user()->id,
            'title'   => $request->title,
            'body'    => $request->body,
        ]);
        session()->flash('success', '投稿を追加しました♪');
        return redirect()->route('posts.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $post = Post::find($id);
        return view('posts.edit', [
            'title' => '投稿編集',
            'post'  => $post,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(PostRequest $request, Post $post)
    {
        $post->update([
            'title' => $request->title,
            'body'  => $request->body,
        ]);
        session()->flash('success', '投稿を編集しました♪');
        return redirect()->route('posts.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Post $post)
    {
        $post->delete();
        session()->flash('success', '投稿を削除しました');
        return redirect()->route('posts.index');
    }
    
    public function editIndex()
    {
        $posts = \Auth::user()->posts()->latest()->get();
        return view ('posts.edit_index', [
            'title' => '投稿編集',
            'posts' => $posts,
        ]);
    }
}