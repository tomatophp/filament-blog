<?php

namespace TomatoPHP\FilamentBlog\Livewire;

use Filament\Actions\Action;
use Filament\Actions\Concerns\InteractsWithActions;
use Filament\Actions\Contracts\HasActions;
use Filament\Notifications\Notification;
use Filament\Schemas\Concerns\InteractsWithSchemas;
use Filament\Schemas\Contracts\HasSchemas;
use Illuminate\Contracts\View\View;
use Livewire\Component;
use TomatoPHP\FilamentBlog\FilamentBlog;
use TomatoPHP\FilamentBlog\Services\Interactions;
use TomatoPHP\FilamentCms\Models\Post;

class LikePost extends Component implements HasActions, HasSchemas
{
    use InteractsWithActions;
    use InteractsWithSchemas;

    public Post $post;

    public function mount(Post $post): void
    {
        $this->post = $post;
    }

    public function likeAction(): Action
    {
        return Action::make('like')
            ->label(trans('filament-blog::messages.likes.action'))
            ->icon(function (): string {
                $account = FilamentBlog::account();

                return ($account && Interactions::isLiked($account, $this->post)) ? 'heroicon-s-heart' : 'heroicon-o-heart';
            })
            ->color('danger')
            ->badge(fn (): int => (int) $this->post->likes)
            ->badgeColor('danger')
            ->action(function () {
                $account = FilamentBlog::account();

                if (! $account) {
                    Notification::make()
                        ->title(trans('filament-blog::messages.likes.notifications.title'))
                        ->body(trans('filament-blog::messages.likes.notifications.body'))
                        ->warning()
                        ->send();

                    return redirect()->to(url(config('filament-blog.user-panel').'/login'));
                }

                Interactions::toggleLike($account, $this->post);

                $this->post->refresh();

                return null;
            });
    }

    public function render(): View
    {
        return view('filament-blog::livewire.like');
    }
}
