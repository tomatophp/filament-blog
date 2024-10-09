<?php

namespace TomatoPHP\FilamentBlog\Http\Controllers;


class AuthController extends Controller
{
    public function login()
    {
        return redirect()->to('/user/login');
    }

    public function register()
    {
        return redirect()->to('/user/register');
    }
}
