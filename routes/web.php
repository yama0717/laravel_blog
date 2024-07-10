<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\FollowController;

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

Route::resource('users', UserController::class)->only(['show',]);  

Route::resource('follows', FollowController::class)->only([
  'index', 'store', 'destroy'
]);
Route::get('/follower', [FollowController::class, 'followerIndex']);
