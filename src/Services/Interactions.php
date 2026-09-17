<?php

namespace TomatoPHP\FilamentBlog\Services;

use Filament\Actions\Action;
use Filament\Notifications\Notification;
use Illuminate\Database\Eloquent\Model;
use TomatoPHP\FilamentBlog\Models\AccountLog;
use TomatoPHP\FilamentBlog\Models\Comment;
use TomatoPHP\FilamentBlog\Models\Like;
use TomatoPHP\FilamentCms\Models\Post;

/**
 * Likes, comments and activity logs of frontend accounts. Works with any account model,
 * the host model does not need the InteractsWithBlog trait.
 */
class Interactions
{
    public static function isLiked(Model $account, Post $post): bool
    {
        return Like::query()
            ->where('account_id', $account->getKey())
            ->where('post_id', $post->getKey())
            ->exists();
    }

    /**
     * Like the post, or remove the like when it already exists. Returns the new like state.
     */
    public static function toggleLike(Model $account, Post $post): bool
    {
        $like = Like::query()
            ->where('account_id', $account->getKey())
            ->where('post_id', $post->getKey())
            ->first();

        if ($like) {
            $like->delete();

            static::notifyAuthor($post, 'New Dislike', static::accountName($account).' disliked your post.');

            return false;
        }

        Like::query()->create([
            'account_id' => $account->getKey(),
            'post_id' => $post->getKey(),
        ]);

        static::log($account, $post, 'like', 'liked post');
        static::notifyAuthor($post, 'New Like', static::accountName($account).' liked your post.');

        return true;
    }

    public static function comment(Model $account, Post $post, string $comment): Comment
    {
        $record = Comment::query()->create([
            'user_id' => $account->getKey(),
            'user_type' => $account->getMorphClass(),
            'content_id' => $post->getKey(),
            'content_type' => $post->getMorphClass(),
            'comment' => $comment,
            'is_active' => true,
        ]);

        static::log($account, $post, 'comment', $comment);
        static::notifyAuthor($post, 'New Comment', static::accountName($account).' added a new comment to your post.');

        return $record;
    }

    public static function log(Model $account, Model $model, string $action = 'comment', ?string $log = null, ?string $date = null): AccountLog
    {
        $data = [
            'account_id' => $account->getKey(),
            'action' => $action,
            'log' => $log,
            'model_type' => $model->getMorphClass(),
            'model_id' => $model->getKey(),
        ];

        if ($date) {
            $data['created_at'] = $date;
        }

        return AccountLog::query()->create($data);
    }

    protected static function notifyAuthor(Post $post, string $title, string $body): void
    {
        if (! config('filament-blog.notify_authors', true)) {
            return;
        }

        $author = $post->author;

        if (! $author instanceof Model || ! method_exists($author, 'notify')) {
            return;
        }

        Notification::make()
            ->title($title)
            ->body($body)
            ->actions([
                Action::make('view')
                    ->label('View Post')
                    ->url(url(trim((string) config('filament-blog.admin-panel', 'admin'), '/').'/posts/'.$post->getKey().'/show')),
            ])
            ->success()
            ->sendToDatabase($author);
    }

    protected static function accountName(Model $account): string
    {
        return (string) ($account->getAttribute('name') ?? $account->getKey());
    }
}
