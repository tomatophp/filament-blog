<?php

namespace TomatoPHP\FilamentBlog\Http\Controllers;

use Illuminate\Contracts\View\View;

class BlogController extends Controller
{
    public function index(): View
    {
        return view('filament-blog::blog.index', [
            'posts' => $this->applyFilter($this->published('post'))->paginate(12),
        ]);
    }

    public function show(string $post): View
    {
        return view('filament-blog::blog.show', [
            'post' => $this->findPublished('post', $post),
        ]);
    }
}
