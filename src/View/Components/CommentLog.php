<?php

namespace TomatoPHP\FilamentBlog\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;
use TomatoPHP\FilamentBlog\Models\AccountLog;

class CommentLog extends Component
{
    public function __construct(public AccountLog $log) {}

    public function render(): View|Closure|string
    {
        return view('filament-blog::components.comment-log');
    }
}
