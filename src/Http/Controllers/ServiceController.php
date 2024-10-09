<?php

namespace TomatoPHP\FilamentBlog\Http\Controllers;

use TomatoPHP\FilamentCms\Models\Post;

class ServiceController extends Controller
{
    public function index()
    {
        $services = Post::query()
            ->where('type', 'service')
            ->where('is_published', 1)
            ->orderBy('created_at', 'desc')
            ->paginate(12);
        return view('filament-blog::services.index', [
            'services' => $services
        ]);
    }

    public function show($service)
    {
        $service = Post::query()->where('slug', $service)->first();
        $service->views += 1;
        $service->save();
        return view('filament-blog::services.show', [
            "service" => $service
        ]);
    }
}
