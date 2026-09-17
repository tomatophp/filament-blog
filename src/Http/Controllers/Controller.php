<?php

namespace TomatoPHP\FilamentBlog\Http\Controllers;

use Illuminate\Database\Eloquent\Builder;
use TomatoPHP\FilamentCms\Models\Post;

abstract class Controller
{
    /**
     * Published posts of the given type.
     */
    protected function published(string $type): Builder
    {
        return Post::query()
            ->where('type', $type)
            ->where('is_published', true);
    }

    /**
     * A published post of the given type by slug, counting the view.
     */
    protected function findPublished(string $type, string $slug): Post
    {
        /** @var Post $post */
        $post = $this->published($type)->where('slug', $slug)->firstOrFail();

        $post->increment('views');

        return $post;
    }

    public function applyFilter(Builder $query, string $key = 'category'): Builder
    {
        if (request()->filled('search')) {
            $query->where('slug', 'like', '%'.request()->string('search').'%');
        }

        match (request()->get('sort')) {
            'popular' => $query->orderByDesc('views'),
            'alphabetical' => $query->orderBy('slug'),
            default => $query->orderByDesc('created_at'),
        };

        if (request()->filled($key)) {
            $query->whereHas('categories', function (Builder $query) use ($key) {
                $query->where('slug', request()->get($key));
            });
        }

        return $query;
    }
}
