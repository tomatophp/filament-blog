<?php

namespace TomatoPHP\FilamentBlog\Http\Controllers;

use Illuminate\Contracts\View\View;

class ServiceController extends Controller
{
    public function index(): View
    {
        return view('filament-blog::services.index', [
            'services' => $this->published('service')->orderByDesc('created_at')->paginate(12),
        ]);
    }

    public function show(string $service): View
    {
        return view('filament-blog::services.show', [
            'service' => $this->findPublished('service', $service),
        ]);
    }
}
