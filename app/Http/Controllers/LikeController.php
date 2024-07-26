<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\User;
use App\Models\Like;

class LikeController extends Controller
{

    public function index()
    {
        $user = \Auth::user();
        $like_posts = \Auth::user()->likePosts()
                          ->withPivot('created_at AS joined_at')
                          ->orderBy('joined_at', 'desc')->get();
        
        return view('likes.index',[
            'title' => 'お気に入り一覧',
            'user' => $user,
            'like_posts' => $like_posts,
        ]);
    }


    public function store($id)
    {
        

    }

    public function destroy()
    {

    }
    
    //  public function toggleLike($id){
    //     $user = \Auth::user();
    //     $post = Post::find($id);
 
    //     if($post->isLikedBy($user)){
    //       // いいねの取り消し
    //       $post->likes->where('user_id', $user->id)->first()->delete();
    //       \Session::flash('success', 'いいねを取り消しました');
    //     } else {
    //       // いいねを設定
    //       Like::create([
    //           'user_id' => $user->id,
    //           'post_id' => $post->id,
    //     ]);
    //     \Session::flash('success', 'いいねしました');
    //     }
    //     return back();
    //   }
}
