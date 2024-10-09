<?php

namespace TomatoPHP\FilamentBlog\Traits;

use Filament\Notifications\Notification;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use TomatoPHP\FilamentBlog\Models\AccountLog;
use TomatoPHP\FilamentBlog\Models\Like;
use TomatoPHP\FilamentCms\Models\Comment;
use TomatoPHP\FilamentCms\Models\Post;

trait InteractsWithBlog
{
    /**
     * @return HasMany
     */
    public function likes(): HasMany
    {
        return $this->hasMany(Like::class, 'account_id', 'id');
    }

    public function like(Post $post)
    {
        $exists = $this->likes()->where('post_id',$post->id)->first();

        if(!$exists){
            $this->likes()->create(['post_id' => $post->id]);
            $post->likes +=1;
            $post->save();

            $this->log($post, 'like', 'liked post');
            if($post->author){
                Notification::make()
                    ->title("New Like")
                    ->body("{$this->name} liked your post.")
                    ->actions([
                        \Filament\Notifications\Actions\Action::make('viewComment')
                            ->label('View Comment')
                            ->url(url('/admin/posts/' . $post->id . '/show'))
                    ])
                    ->success()
                    ->sendToDatabase($post->author);
            }
        }
        else {
            $exists->delete();

            $post->likes -=1;
            $post->save();

            if($post->author){
                Notification::make()
                    ->title("New Dislike")
                    ->body("{$this->name} disliked your post.")
                    ->actions([
                        \Filament\Notifications\Actions\Action::make('viewComment')
                            ->label('View Comment')
                            ->url(url('/admin/posts/' . $post->id . '/show'))
                    ])
                    ->success()
                    ->sendToDatabase($post->author);
            }

        }
    }

    /**
     * @return MorphMany
     */
    public function comments(): MorphMany
    {
        return $this->morphMany(Comment::class, 'user');
    }


    /**
     * @param Post $post
     * @return bool
     */
    public function isLike(Post $post): bool
    {
        return (bool)$this->likes()->where('post_id', $post->id)->first();
    }

    /**
     * @return HasMany
     */
    public function logs(): HasMany
    {
        return $this->hasMany(AccountLog::class);
    }


    /**
     * @param Model $model
     * @param string $action
     * @param string|null $log
     * @param string|null $date
     * @return Model
     */
    public function log(Model $model, string $action='comment', string $log =null, string $date=null): Model
    {
        $data = [
            'action' => $action,
            'log' => $log,
            'model_type' => $model ? get_class($model) : null,
            'model_id' => $model ? $model->id : null,
        ];

        if($date){
            $data['created_at'] = $date;
        }

        return $this->logs()->create($data);
    }
}
