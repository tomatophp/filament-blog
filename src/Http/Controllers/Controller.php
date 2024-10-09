<?php

namespace TomatoPHP\FilamentBlog\Http\Controllers;

use Illuminate\Database\Eloquent\Builder;

abstract class Controller
{
    public function applyFilter(Builder $query,string $key='category'): Builder
    {
        if(request()->has('search') && !empty('search')){
            $query
                ->where('slug', 'like', '%'.request()->search.'%');
        }

        if(request()->has('sort') && !empty('sort')){
            if(request()->get('sort') === 'popular'){
                $query->orderBy('views', 'desc');
            }
            elseif (request()->get('sort') === 'recent'){
                $query->orderBy('created_at', 'desc');
            }
            elseif (request()->get('sort') === 'alphabetical'){
                $query->orderBy('title');
            }
            else {
                $query->orderBy('created_at', 'desc');
            }
        }

        if(request()->has($key) && !empty($key)){
            $query->whereHas('categories', function ($query) use ($key){
                $query->where('slug', request()->get($key));
            });
        }

        return $query;
    }
}
