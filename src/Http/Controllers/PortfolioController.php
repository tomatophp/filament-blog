<?php

namespace TomatoPHP\FilamentBlog\Http\Controllers;

use Illuminate\Contracts\View\View;

class PortfolioController extends Controller
{
    public function index(): View
    {
        return view('filament-blog::portfolio.index', [
            'portfolios' => $this->applyFilter($this->published('portfolio'), 'service')->paginate(12),
        ]);
    }

    public function show(string $portfolio): View
    {
        return view('filament-blog::portfolio.show', [
            'portfolio' => $this->findPublished('portfolio', $portfolio),
        ]);
    }
}
