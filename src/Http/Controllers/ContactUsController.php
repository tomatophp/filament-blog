<?php

namespace TomatoPHP\FilamentBlog\Http\Controllers;

class ContactUsController extends Controller
{
    public function index()
    {
        return view('filament-blog::contact-us.index');
    }
}
