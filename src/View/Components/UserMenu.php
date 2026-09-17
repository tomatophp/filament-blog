<?php

namespace TomatoPHP\FilamentBlog\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class UserMenu extends Component
{
    public function render(): View|Closure|string
    {
        return view('filament-blog::components.user-menu');
    }
}
