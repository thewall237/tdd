<?php

use App\Http\Controllers\PostController;
use Illuminate\Support\Facades\Route;

//　ブログ一覧画面
Route::get('/', [PostController::class, 'index']);
// ブログ詳細画面
Route::get('posts/{post}', [PostController::class, 'show'])->name('posts.show')->whereNumber('post');
