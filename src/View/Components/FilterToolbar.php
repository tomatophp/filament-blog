<?php

namespace TomatoPHP\FilamentBlog\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class FilterToolbar extends Component
{

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('filament-blog::components.filter-toolbar');
    }
}
