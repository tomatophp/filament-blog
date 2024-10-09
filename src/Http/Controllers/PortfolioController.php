<?php

namespace TomatoPHP\FilamentBlog\Http\Controllers;

use TomatoPHP\FilamentCms\Models\Post;

class PortfolioController extends Controller
{
    public function index()
    {
        $portfolios = Post::query()
            ->where('type', 'portfolio')
            ->where('is_published', 1);

        $portfolios = $this->applyFilter($portfolios);

        $portfolios = $portfolios->paginate(12);
        return view('filament-blog::portfolio.index', [
            'portfolios' => $portfolios
        ]);
    }
    public function show($portfolio)
    {
        $portfolio = Post::query()->where('slug', $portfolio)->first();
        $portfolio->views += 1;
        $portfolio->save();
        return view('filament-blog::portfolio.show', [
            "portfolio" => $portfolio
        ]);
    }
}
