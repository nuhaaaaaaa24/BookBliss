<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Models\Like;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PostController extends Controller
{
    public function index()
    {
        $posts = Post::latest()->get();
        return view('forum.index', compact('posts'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'body' => 'required'
        ]);

        Post::create([
            'title' => $request->title,
            'body' => $request->body,
            'user_id' => Auth::id()
        ]);

        return back();
    }

    public function like(Post $post)
    {
        Like::create([
            'user_id' => Auth::id(),
            'post_id' => $post->id
        ]);

        return back();
    }
    public function comment(Request $request, Post $post)
    {
        $request->validate([
            'body' => 'required|string'
        ]);

        $post->comments()->create([
            'body' => $request->body,
            'user_id' => auth()->id()
        ]);

        return back();
    }
}