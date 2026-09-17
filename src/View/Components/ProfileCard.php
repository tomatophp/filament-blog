<?php

namespace TomatoPHP\FilamentBlog\View\Components;

use Illuminate\Database\Eloquent\Model;
use Illuminate\View\Component;
use Illuminate\View\View;

class ProfileCard extends Component
{
    public function __construct(public Model $account) {}

    public function render(): View|string
    {
        return view('filament-blog::components.profile-card');
    }
}
