<?php

namespace App\Http\Controllers;

use App\Models\Follow;
use Illuminate\Http\Request;

class FollowController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $follow_users = \Auth::user()->follow_users;
        
        return view('follows.index', [
            'title' => 'フォロー一覧',
            'follow_users' => $follow_users,
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
        // return redirect()->route('users.show', $id);
        return back();
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }


    public function destroy(string $id)
    {
        $follow = \Auth::user()->follows->where('follow_id', $id)->first();
        $follow->delete();
        \Session::flash('success', 'フォローを解除しました');
        return redirect()->route('users.show', $id);
    }
    
    public function follwerIndex()
    {
    return view('follows.follower_index', [
      'title' => 'フォロワー一覧',
    ]);
    }
}
