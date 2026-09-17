<?php

namespace TomatoPHP\FilamentBlog\Http\Controllers;

use Illuminate\Contracts\View\View;

class OpenSourceController extends Controller
{
    public function index(): View
    {
        return view('filament-blog::open-source.index', [
            'openSources' => $this->applyFilter($this->published('open-source'))->paginate(12),
        ]);
    }

    public function show(string $docs): View
    {
        return view('filament-blog::open-source.show', [
            'docs' => $this->findPublished('open-source', $docs),
        ]);
    }
}
