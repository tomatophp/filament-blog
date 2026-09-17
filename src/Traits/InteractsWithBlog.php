<?php

namespace TomatoPHP\FilamentBlog\Traits;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use TomatoPHP\FilamentBlog\Models\AccountLog;
use TomatoPHP\FilamentBlog\Models\Comment;
use TomatoPHP\FilamentBlog\Models\Like;
use TomatoPHP\FilamentBlog\Services\Interactions;
use TomatoPHP\FilamentCms\Models\Post;

/**
 * Optional helpers for the account model. The package itself uses the Interactions service,
 * so accounts work without this trait.
 */
trait InteractsWithBlog
{
    public function likes(): HasMany
    {
        return $this->hasMany(Like::class, 'account_id', 'id');
    }

    public function like(Post $post): bool
    {
        return Interactions::toggleLike($this, $post);
    }

    public function comments(): MorphMany
    {
        return $this->morphMany(Comment::class, 'user');
    }

    public function isLike(Post $post): bool
    {
        return Interactions::isLiked($this, $post);
    }

    public function logs(): HasMany
    {
        return $this->hasMany(AccountLog::class, 'account_id', 'id');
    }

    public function log(Model $model, string $action = 'comment', ?string $log = null, ?string $date = null): Model
    {
        return Interactions::log($this, $model, $action, $log, $date);
    }
}
