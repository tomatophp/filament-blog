<?php

namespace TomatoPHP\FilamentBlog\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use TomatoPHP\FilamentBlog\FilamentBlog;
use TomatoPHP\FilamentCms\Models\Post;

/**
 * @property int $id
 * @property int $account_id
 * @property int $post_id
 * @property Post|null $post
 */
class Like extends Model
{
    protected $fillable = ['account_id', 'post_id'];

    /**
     * Keep the cached counter on the post in sync, however the like is created or deleted.
     */
    protected static function booted(): void
    {
        static::created(function (Like $like): void {
            $like->post?->increment('likes');
        });

        static::deleted(function (Like $like): void {
            $post = $like->post;

            if ($post && $post->likes > 0) {
                $post->decrement('likes');
            }
        });
    }

    public function post(): BelongsTo
    {
        return $this->belongsTo(Post::class);
    }

    public function account(): BelongsTo
    {
        return $this->belongsTo(FilamentBlog::accountModel(), 'account_id');
    }
}
