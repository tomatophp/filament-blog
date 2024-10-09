<?php

namespace TomatoPHP\FilamentBlog;

use Filament\Contracts\Plugin;
use Filament\Panel;
use TomatoPHP\FilamentAccounts\FilamentAccountsPlugin;
use TomatoPHP\FilamentCms\FilamentCMSPlugin;
use TomatoPHP\FilamentMenus\FilamentMenusPlugin;
use TomatoPHP\FilamentSeo\FilamentSeoPlugin;
use TomatoPHP\FilamentSettingsHub\FilamentSettingsHubPlugin;

class FilamentBlogPlugin implements Plugin
{
    public function getId(): string
    {
        return 'filament-blog';
    }

    public function register(Panel $panel): void
    {
        $panel->plugin(
            FilamentCMSPlugin::make()
        );

        $panel->plugin(
            FilamentSettingsHubPlugin::make()
        );

        $panel->plugin(
            FilamentSeoPlugin::make()
        );

        $panel->plugin(
            FilamentMenusPlugin::make()
        );

        $panel->plugin(
            FilamentAccountsPlugin::make()
                ->canLogin()
                ->canBlocked()
        );
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
