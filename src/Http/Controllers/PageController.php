<?php

namespace TomatoPHP\FilamentBlog\Http\Controllers;

use Illuminate\Contracts\View\View;

class PageController extends Controller
{
    public function index(): View
    {
        return view('filament-blog::index');
    }

    public function show(string $page): View
    {
        return view('filament-blog::page', [
            'page' => $this->findPublished('page', $page),
        ]);
    }
}
