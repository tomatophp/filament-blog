<?php

namespace TomatoPHP\FilamentBlog\Http\Controllers;

use Illuminate\Http\RedirectResponse;

class AuthController extends Controller
{
    public function login(): RedirectResponse
    {
        return redirect()->to(url(config('filament-blog.user-panel').'/login'));
    }

    public function register(): RedirectResponse
    {
        return redirect()->to(url(config('filament-blog.user-panel').'/register'));
    }
}
