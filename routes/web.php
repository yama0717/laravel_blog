<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\FollowController;
use App\Http\Controllers\LikeController;
use App\Http\Controllers\CommentController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/
Auth::routes();

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/', [PostController::class, 'index'])->name('posts.index');
Route::get('posts.edit_index', [PostController::class, 'editIndex'])->name('posts.edit_index');

Route::resource('posts', PostController::class);
Route::get('/posts/{post}/edit_image', [PostController::class, 'editImage'])->name('posts.edit_image');
Route::patch('/posts/{post}/edit_image', [PostController::class, 'updateImage'])->name('posts.update_image');
Route::delete('/posts/{post}/destroy_image', [PostController::class, 'destroyImage'])->name('posts.destroy_image');

Route::controller(UserController::class)->group(function () { 
  Route::get('/users/edit',  'edit')->name('users.edit');
  Route::patch('/users', 'update')->name('users.update');
  Route::get('/users/edit_image', 'editImage')->name('users.edit_image');
  Route::patch('/users/edit_image', 'updateImage')->name('users.update_image');
  Route::get('/users/search', 'userSearch')->name('users.search');
 
  Route::resource('users', UserController::class)->only([
  'show',
  ]);  
});

Route::resource('follows', FollowController::class)->only([
  'index', 'store', 'destroy'
]);

Route::get('/follower', [FollowController::class, 'followerIndex'])->name('follows.follower_index');

Route::resource('likes', LikeController::class)->only([
  'index', 'store', 'destroy'
]);
Route::post('/posts/{post}/toggle_like', [PostController::class, 'toggleLike'])->name('posts.toggle_like');
Route::delete('/posts/{post}/toggle_like', [PostController::class, 'toggleLike'])->name('posts.toggle_like_delete');

Route::resource('comments', CommentController::class)->only([
  'store', 'destroy'
]);