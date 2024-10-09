<?php

namespace TomatoPHP\FilamentBlog\Http\Controllers;

use Illuminate\Http\Request;
use TomatoPHP\FilamentCms\Models\Post;

class OpenSourceController extends Controller
{
    public function index(Request $request)
    {
        $openSources = Post::query()
            ->where('type', 'open-source')
            ->where('is_published', 1);

        $openSources = $this->applyFilter($openSources);

        $openSources = $openSources->paginate(12);
        return view('filament-blog::open-source.index', [
            'openSources' => $openSources
        ]);
    }

    public function show($docs)
    {
        $docs = Post::query()
            ->where('slug', $docs)
            ->first();

        if($docs){
            $docs->views += 1;
            $docs->save();

            return view('filament-blog::open-source.show', [
                "docs" => $docs
            ]);
        }
        else {
            abort(404);
        }

    }
}
