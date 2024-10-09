<?php

namespace TomatoPHP\FilamentBlog\Livewire;

use Filament\Actions\Action;
use Filament\Actions\Concerns\InteractsWithActions;
use Filament\Actions\Contracts\HasActions;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Notifications\Notification;
use Livewire\Component;
use TomatoPHP\FilamentCms\Filament\Resources\PostResource;
use TomatoPHP\FilamentCms\Models\Post;

class LikePost extends Component implements HasActions, HasForms
{
    use InteractsWithActions;
    use InteractsWithForms;

    public ?Post $post = null;

    public function mount(Post $post)
    {
        $this->post = $post;
    }

    public function getLikeActions(): Action
    {
        return Action::make('getLikeActions')
            ->label(trans('filament-blog::messages.likes.action'))
            ->icon(fn()=> (auth('accounts')->user() && auth('accounts')->user()->isLike($this->post)) ? 'heroicon-s-heart' : 'heroicon-o-heart')
            ->color('danger')
            ->badge(fn() => $this->post->likes)
            ->badgeColor('danger')
            ->action(function(){
                if(!auth('accounts')->user()){
                    Notification::make()
                        ->title(trans('filament-blog::messages.likes.notifications.title'))
                        ->body(trans('filament-blog::messages.likes.notifications.body'))
                        ->warning()
                        ->send();
                    return redirect()->to('user');
                }
                else {
                    auth('accounts')->user()->like($this->post);
                }
            });
    }

    public function render()
    {
        return view('filament-blog::livewire.like');
    }
}
