<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});
Route::get('/sport', function () {
    return view('sport');
});
Route::get('/paneladmin', function () {
    return view('panel-admin');
});

Auth::routes();
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');



/**
 * soft delete Route
 */
//add posts
Route::get('/posts',[App\Http\Controllers\PostController::class,'index'])->name('posts');
Route::post('/send-post',[App\Http\Controllers\PostController::class,'savePost'])->name('send.post');
Route::get('/send-post',function (){
    return view('send-post');
});
//soft delete
Route::delete('/post/delete/{id}',[App\Http\Controllers\PostController::class,'deletePost'])->name('posts.destroy');
Route::get('/posts/all/restore',[App\Http\Controllers\PostController::class,'restoreAllPost'])->name('posts.allRestore');
Route::get('/posts/restore/{id}',[App\Http\Controllers\PostController::class,'restorePost'])->name('posts.restore');

/**
 * Forum
 */

Route::group(['prefix'=>'/discuss'],function(){

    Route::get('',[App\Http\Controllers\ThreadController::Class,'index'])->name('threads');
    Route::post('',[App\Http\Controllers\ThreadController::class,'replyThread'])->name('threads.reply');

    Route::get('{thread:slug}',[App\Http\Controllers\ThreadController::Class,'getThreadDetail'])->name('detail');
    Route::post('{thread:slug}',[App\Http\Controllers\ThreadController::Class,'getThreadDetailBest']);



    Route::get('/{thread:slug}/solved',[App\Http\Controllers\ThreadController::Class,'solvedThread']);
    Route::get('/{thread:slug}/liked',[App\Http\Controllers\ThreadController::Class,'likeThread'])->middleware('auth');
    Route::get('/{thread:slug}/unliked',[App\Http\Controllers\ThreadController::Class,'unlikeThread'])->middleware('auth');
    Route::get('/{thread:slug}/{reply}/liked',[App\Http\Controllers\ThreadController::Class,'likeReply'])->middleware('auth');
    Route::get('/{thread:slug}/{reply}/unliked',[App\Http\Controllers\ThreadController::Class,'unlikeReply'])->middleware('auth');


    Route::post('/channels/{channel:slug}',[App\Http\Controllers\ThreadController::Class,'addThread']);
    Route::get('/channels/{channel:slug}',[App\Http\Controllers\ChannelController::Class,'getChannelDetail']);




});



