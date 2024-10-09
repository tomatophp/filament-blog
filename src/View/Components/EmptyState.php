<?php

namespace TomatoPHP\FilamentBlog\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;
use TomatoPHP\FilamentCms\Models\Post;

class EmptyState extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct(
        public string $name,
    )
    {
        //
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('filament-blog::components.empty');
    }
}
