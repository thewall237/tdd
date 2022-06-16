<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function index() {
        $posts = Post::query()
            // ->where('status', Post::OPEN)
            ->onlyOpen()
            ->with('user')
            ->withCount('comments')
            ->orderByDesc('comments_count')
            ->get();

        return view('index', ['posts' => $posts]);
    }

    public function show(Post $post)
    {
        // if($post->status == Post::CLOSED) {
        //     abort(403);
        // }
        if($post->isClosed()) {
            abort(403);
        }

        return view('posts.show', ['post' => $post,]);
    }
}
