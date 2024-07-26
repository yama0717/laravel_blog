<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Comment;
use App\Http\Requests\CommentRequest;

class CommentController extends Controller
{
    public function store(CommentRequest $request)
    {
        Comment::create([
            'post_id' => $request->post_id,
            'user_id' => \Auth::user()->id,
            'body'    => $request->body,
        ]);
        session()->flash('success', 'コメントを投稿しました♪');
        return back();
    }
    
    public function destroy(Comment $comment)
    {
        $comment->delete();
        session()->flash('success', 'コメントを削除しました');
        return back();
    }
}
