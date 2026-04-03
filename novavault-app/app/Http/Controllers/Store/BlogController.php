<?php

namespace App\Http\Controllers\Store;

use App\Http\Controllers\Controller;
use App\Models\Post;
use Illuminate\View\View;

class BlogController extends Controller
{
    public function index(): View
    {
        $posts = Post::published()->with('author')->latest('published_at')->paginate(12);
        return view('blog.index', compact('posts'));
    }

    public function show(Post $post): View
    {
        if ($post->status !== 'published') abort(404);
        return view('blog.show', compact('post'));
    }
}
