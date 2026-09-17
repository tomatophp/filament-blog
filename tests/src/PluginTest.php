<?php

use Filament\Facades\Filament;
use Filament\Panel;
use TomatoPHP\FilamentBlog\Filament\Resources\CommentResource;
use TomatoPHP\FilamentBlog\Filament\Resources\LikeResource;
use TomatoPHP\FilamentBlog\Filament\Widgets\StateWidget;
use TomatoPHP\FilamentBlog\FilamentBlogPlugin;
use TomatoPHP\FilamentBlog\FilamentBlogServiceProvider;
use TomatoPHP\FilamentMenus\FilamentMenusPlugin;

it('boots the service provider', function () {
    expect(app()->getProviders(FilamentBlogServiceProvider::class))->not->toBeEmpty()
        ->and(config('filament-blog.user-panel'))->toBe('app');
});

it('registers the blog plugin and the plugins it depends on on the admin panel', function () {
    $panel = Filament::getPanel('admin');

    expect($panel->hasPlugin('filament-blog'))->toBeTrue()
        ->and($panel->hasPlugin('filament-cms'))->toBeTrue()
        ->and($panel->hasPlugin('filament-menus'))->toBeTrue()
        ->and($panel->hasPlugin('filament-seo'))->toBeTrue()
        ->and($panel->hasPlugin('filament-settings-hub'))->toBeTrue()
        ->and($panel->hasPlugin('filament-accounts'))->toBeTrue();
});

it('registers the comments, likes and stats on the user panel', function () {
    $panel = Filament::getPanel('app');

    expect($panel->hasPlugin('filament-blog-user-panel'))->toBeTrue()
        ->and($panel->getResources())->toContain(CommentResource::class, LikeResource::class)
        ->and($panel->getWidgets())->toContain(StateWidget::class);
});

it('registers the accounts guard when the app does not define it', function () {
    expect(config('auth.guards.accounts.driver'))->toBe('session')
        ->and(config('auth.providers.accounts.model'))->toBe(config('filament-accounts.model'))
        ->and(auth('accounts')->guest())->toBeTrue();
});

it('keeps plugins the panel already registered with their own configuration', function () {
    $menus = FilamentMenusPlugin::make();

    $panel = Panel::make()
        ->id('blog-plugin-order')
        ->plugin($menus)
        ->plugin(FilamentBlogPlugin::make());

    expect($panel->getPlugin('filament-menus'))->toBe($menus)
        ->and($panel->hasPlugin('filament-cms'))->toBeTrue()
        ->and($panel->hasPlugin('filament-seo'))->toBeTrue();
});
