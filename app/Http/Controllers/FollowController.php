<?php

namespace App\Http\Controllers;

use App\Models\Follow;
use App\Models\User;
use Illuminate\Http\Request;

class FollowController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index()
    {
        // 新着順
        $follow_users = \Auth::user()->follow_users()->latest()->get();
        $count = \Auth::user()->follow_users()->count();
        return view('follows.index', [
            'title' => 'フォロー一覧',
            'follow_users' => $follow_users,
            'count' => $count,
        ]);
    }



    public function store(Request $request)
    {
        $user = \Auth::user();
        Follow::create([
            'user_id' => $user->id,
            'follow_id' => $request->follow_id,
        ]);
        
        \Session::flash('success', 'フォローしました');
        return back();
    }

    //もう一度説明してもらう
    //   public function store($id)
    // {
    //     $user = \Auth::user();
    //     Follow::create([
    //         'user_id' => $user->id,
    //         'follow_id' => $id->follow_id,
    //     ]);
        
    //     \Session::flash('success', 'フォローしました');
    //     return redirect()->route('users.show', $id);
    // }


    public function destroy(string $id)
    {
        $follow = \Auth::user()->follows->where('follow_id', $id)->first();
        $follow->delete();
        \Session::flash('success', 'フォローを解除しました');
        return redirect()->route('users.show', $id);
    }
    
    public function followerIndex()
    {
        $followers = \Auth::user()->followers()->latest()->get();
        $count = \Auth::user()->followers()->count();
        return view('follows.follower_index', [
          'title' => 'フォロワー一覧',
          'followers' => $followers,
          'count' => $count
          
    ]);
    }
}
