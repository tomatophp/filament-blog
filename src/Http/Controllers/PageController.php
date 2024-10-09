<?php

namespace TomatoPHP\FilamentBlog\Http\Controllers;

use App\Models\Account;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use TomatoPHP\FilamentCms\Models\Post;

class PageController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        return view('filament-blog::index');
    }

    public function show($page)
    {
        $page = Post::query()->where('type', 'page')->where('slug', $page)->first();

        if($page){
            $page->views += 1;
            $page->save();

            return view('filament-blog::page', [
                'page' => $page
            ]);
        }
        else {
            abort(404);
        }
    }
}
