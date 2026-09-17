<?php

namespace TomatoPHP\FilamentBlog\Filament\Widgets;

use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use TomatoPHP\FilamentBlog\FilamentBlog;
use TomatoPHP\FilamentBlog\Models\Comment;
use TomatoPHP\FilamentBlog\Models\Like;
use TomatoPHP\FilamentCms\Models\Post;

class StateWidget extends BaseWidget
{
    protected ?string $pollingInterval = null;

    protected function getStats(): array
    {
        $account = FilamentBlog::account();
        $accountId = $account?->getKey();
        $accountType = $account?->getMorphClass();

        return [
            Stat::make(
                trans('filament-blog::messages.widgets.demos'),
                Post::query()->where('author_id', $accountId)->where('author_type', $accountType)->count(),
            )
                ->color('info')
                ->icon('heroicon-o-globe-alt'),
            Stat::make(
                trans('filament-blog::messages.widgets.likes'),
                Like::query()->where('account_id', $accountId)->count(),
            )
                ->color('danger')
                ->icon('heroicon-o-heart'),
            Stat::make(
                trans('filament-blog::messages.widgets.comments'),
                Comment::query()->where('user_id', $accountId)->where('user_type', $accountType)->count(),
            )
                ->color('warning')
                ->icon('heroicon-o-chat-bubble-left-right'),
        ];
    }
}
