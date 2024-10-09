<?php

namespace TomatoPHP\FilamentBlog\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class ServiceCard extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct(
        public string $label,
        public ?string $description = null,
        public ?string $icon = null,
        public ?string $image = null,
        public ?array $tags = [],
        public ?string $url = null,
    )
    {
        //
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('filament-blog::components.service-card');
    }
}
