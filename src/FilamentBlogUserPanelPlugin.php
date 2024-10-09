<?php

namespace TomatoPHP\FilamentBlog;

use Filament\Contracts\Plugin;
use Filament\Panel;
use TomatoPHP\FilamentAccounts\FilamentAccountsPlugin;
use TomatoPHP\FilamentAccounts\FilamentAccountsSaaSPlugin;
use TomatoPHP\FilamentBlog\Filament\Resources\CommentResource;
use TomatoPHP\FilamentBlog\Filament\Resources\LikeResource;
use TomatoPHP\FilamentBlog\Filament\Widgets\StateWidget;
use TomatoPHP\FilamentCms\FilamentCMSPlugin;
use TomatoPHP\FilamentMenus\FilamentMenusPlugin;
use TomatoPHP\FilamentSeo\FilamentSeoPlugin;
use TomatoPHP\FilamentSettingsHub\FilamentSettingsHubPlugin;

class FilamentBlogUserPanelPlugin implements Plugin
{
    public function getId(): string
    {
        return 'filament-blog-user-panel';
    }

    public function register(Panel $panel): void
    {
        $panel->resources([
           CommentResource::class,
           LikeResource::class
        ]);

        $panel->widgets([
            StateWidget::class
        ]);

    }

    public function boot(Panel $panel): void
    {
        //
    }

    public static function make(): static
    {
        return new static();
    }
}
