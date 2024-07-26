<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\User;
use App\Http\Requests\UserRequest;
use App\Http\Requests\UserImageRequest;
use App\Services\FileUploadService;
use Illuminate\Http\Request;

class UserController extends Controller
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
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $user  = User::find($id);
        $posts = Post::where('user_id', $id)->latest()->get();
        
        
        return view('users.show',[
            'title' => 'ユーザー詳細',
            'user'  => $user,
            'posts' => $posts,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit()
    {
        $user = \Auth::user();
        return view('users.edit', [
            'title' => 'プロフィール編集',
            'user' => $user,
        ]);
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UserRequest $request)
    {
        $user = \Auth::user();
        $user->update([
            'name' => $request->name,
            'email'  => $request->email,
            'profile' => $request->profile,
        ]);
        session()->flash('success', 'プロフィールを編集しました♪');
        return redirect()->route('users.show', \Auth::user()->id);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
    public function editImage()
    {
        $user = \Auth::user();
        return view('users.edit_image', [
            'title' => 'プロフィール画像編集',
            'user'  => $user,
        ]);
    }
    public function updateImage(UserImageRequest $request, FileUploadService $service)
    {
        $user = \Auth::user();
        // 
        $path = $service->saveUserImage($request->file('image'));
        // dd($path);
        if($user->image !== ''){
            \Storage::disk('public')->delete($user->image);
        }
        $user->update([
           'image' => $path, 
        ]);
        session()->flash('success', '画像を変更しました♪');
        return redirect()->route('users.show', \Auth::user()->id);
        
    
    }
    public function userSearch(Request $request)
    {
        if (isset($request->keyword)) {
            $users = User::
                where('id', '!=', \Auth::user()->id)
                ->whereany([
                    'name'
                ], 'LIKE','%' . $request->keyword . '%')
                ->latest()->get();

         } 
         else {
            $users = [];
         }
         return view('users.search',[
            'title' => 'ユーザー詳細',
            'users'  => $users,
            'keyword' => $request->keyword,
            
        ]);
    }
}
