<?php

namespace TomatoPHP\FilamentBlog\Filament\Widgets;

use Google\Service\Blogger\Resource\Posts;
use TomatoPHP\FilamentBlog\Models\Like;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use TomatoPHP\FilamentCms\Models\Comment;
use TomatoPHP\FilamentCms\Models\Post;

class StateWidget extends BaseWidget
{
    protected static ?string $pollingInterval = null;

    protected function getStats(): array
    {
        return [
            Stat::make(trans('filament-blog::messages.widgets.demos'), Post::query()->where('user_id', auth('accounts')->user()->id)->where('user_type', config('filament-accounts.model'))->count())
                ->chart(collect(range(1, 10))->map(fn ($item) => (float)rand(1,1000))->toArray())
                ->color('info')
                ->icon('heroicon-o-globe-alt'),
            Stat::make(trans('filament-blog::messages.widgets.likes'), Like::query()->where('account_id', auth('accounts')->user()->id)->count())
                ->chart(collect(range(1, 10))->map(fn ($item) => (float)rand(1,1000))->toArray())
                ->color('danger')
                ->icon('heroicon-o-heart'),
            Stat::make(trans('filament-blog::messages.widgets.comments'), Comment::query()->where('user_id', auth('accounts')->user()->id)->count())
                ->chart(collect(range(1, 10))->map(fn ($item) => (float)rand(1,1000))->toArray())
                ->color('warning')
                ->icon('heroicon-o-chat-bubble-left-right'),
        ];
    }
}
