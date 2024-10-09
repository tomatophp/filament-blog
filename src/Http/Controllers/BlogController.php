<?php

namespace TomatoPHP\FilamentBlog\Http\Controllers;

use Illuminate\Http\Request;
use TomatoPHP\FilamentCms\Models\Post;

class BlogController extends Controller
{
    public function index(Request $request)
    {
        $posts = Post::query()
            ->where('type', 'post')
            ->where('is_published', 1);

        $posts = $this->applyFilter($posts);

        $posts = $posts->paginate(12);

        return view('filament-blog::blog.index', [
            "posts" => $posts
        ]);
    }

    public function show($post)
    {
        $post = Post::query()->where('slug', $post)->first();

        if($post){
            $post->views += 1;
            $post->save();

            return view('filament-blog::blog.show', [
                'post' => $post
            ]);
        }
        else {
            abort(404);
        }

    }
}
