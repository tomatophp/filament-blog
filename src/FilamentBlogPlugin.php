<?php

namespace TomatoPHP\FilamentBlog;

use Filament\Contracts\Plugin;
use Filament\Panel;
use TomatoPHP\FilamentAccounts\FilamentAccountsPlugin;
use TomatoPHP\FilamentCms\FilamentCMSPlugin;
use TomatoPHP\FilamentMenus\FilamentMenusPlugin;
use TomatoPHP\FilamentSeo\FilamentSeoPlugin;
use TomatoPHP\FilamentSettingsHub\FilamentSettingsHubPlugin;

/**
 * Admin panel plugin: registers the CMS, settings, SEO, menus and accounts plugins the frontend is built on.
 */
class FilamentBlogPlugin implements Plugin
{
    public function getId(): string
    {
        return 'filament-blog';
    }

    /**
     * Plugins the panel already registered keep their own configuration; only missing ones are added.
     */
    public function register(Panel $panel): void
    {
        $plugins = [
            'filament-cms' => fn (): Plugin => FilamentCMSPlugin::make(),
            'filament-settings-hub' => fn (): Plugin => FilamentSettingsHubPlugin::make(),
            'filament-seo' => fn (): Plugin => FilamentSeoPlugin::make(),
            'filament-menus' => fn (): Plugin => FilamentMenusPlugin::make(),
            'filament-accounts' => fn (): Plugin => FilamentAccountsPlugin::make()->canLogin()->canBlocked(),
        ];

        foreach ($plugins as $plugin) {
            $plugin = $plugin();

            if (! $panel->hasPlugin($plugin->getId())) {
                $panel->plugin($plugin);
            }
        }
    }

    public function boot(Panel $panel): void
    {
        //
    }

    public static function make(): static
    {
        return app(static::class);
    }
}
