<?php

namespace App\Http\Controllers;
use App\Models\Post;
use App\Models\User;
use App\Models\Like;
use App\Http\Requests\PostRequest;
use App\Http\Requests\PostImageRequest;

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
    public function index(Request $request)
    {
        $user = \Auth::user();
        // フォローしている人
        $follow_user_ids = $user->follow_users->pluck('id');
        // フォローしていない人
        $unfollows = User::whereNotIn('id', $follow_user_ids)
                           ->where('id' , '!=' , $user->id)
                           ->inRandomOrder()->limit(3)->get();



        // 検索
        if (isset($request->keyword)) {
            $posts = Post::
                where('user_id', '!=', \Auth::user()->id)
                ->whereany([
                    'title',
                    'body',
                ], 'LIKE','%' . $request->keyword . '%')
                ->latest()->get();

         } else {
            $posts = $user->posts()->orWhereIn('user_id', $follow_user_ids )->latest()->get();
         }
        return view ('posts.index', [
            'title' => '投稿一覧',
            'user' => $user,
            'posts' => $posts,
            'unfollows' => $unfollows,
            'keyword' => $request->keyword,
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
        $path = null;
        $image = $request->file('image');
        if( isset($image) === true ){
            // publicディスク(storage/app/public/)のphotosディレクトリに保存
            $path = $image->store('photos', 'public');
        }
        Post::create([
            'user_id' => \Auth::user()->id,
            'title'   => $request->title,
            'body'    => $request->body,
            'image' => $path,
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
        if($post->image !== null){
          \Storage::disk('public')->delete($post->image);
        }

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
    
    public function editImage(Post $post)
    {
        
        return view('posts.edit_image', [
            'title' => '画像変更画面',
            'post' => $post,
          ]);
    }
      
    public function updateImage(Post $post, PostImageRequest $request)
    {
        $path = null;
        $image = $request->file('image');
 
        
        if( isset($image) === true ){
            $path = $image->store('photos', 'public');
            
        }
        
        if($post->image !== null){
          \Storage::disk('public')->delete($post->image);
        }
        
        $post->update([
            'image' => $path,
        ]);
        session()->flash('success', '画像を変更しました♪');
        return redirect()->route('posts.index');
    }
    public function destroyImage(Post $post)
    {
        if($post->image !== null){
          \Storage::disk('public')->delete($post->image);
        }
        if($post !== null) {
          $post->update([
            'image' => null,
        ]);
        }
        // $post->delete();
        session()->flash('success', '画像を削除しました');
        return redirect()->route('posts.edit', $post);
    }
    
    public function toggleLike($id){
        $user = \Auth::user();
        $post = Post::find($id);
 
        if($post->isLikedBy($user)){
          // いいねの取り消し
          $post->likes->where('user_id', $user->id)->first()->delete();
          \Session::flash('success', 'いいねを取り消しました');
        } else {
          // いいねを設定
          Like::create([
              'user_id' => $user->id,
              'post_id' => $post->id,
        ]);
        \Session::flash('success', 'いいねしました');
        }
        return back();
      }
}