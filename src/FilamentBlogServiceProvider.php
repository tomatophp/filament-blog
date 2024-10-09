<?php

namespace TomatoPHP\FilamentBlog;

use Illuminate\Support\ServiceProvider;
use Livewire\Livewire;
use TomatoPHP\FilamentBlog\Livewire\CommentPost;
use TomatoPHP\FilamentBlog\Livewire\LikePost;
use TomatoPHP\FilamentBlog\View\Components;


class FilamentBlogServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //Register generate command
        $this->commands([
           \TomatoPHP\FilamentBlog\Console\FilamentBlogInstall::class,
        ]);

        //Register Config file
        $this->mergeConfigFrom(__DIR__.'/../config/filament-blog.php', 'filament-blog');

        //Publish Config
        $this->publishes([
           __DIR__.'/../config/filament-blog.php' => config_path('filament-blog.php'),
        ], 'filament-blog-config');

        //Register Migrations
        $this->loadMigrationsFrom(__DIR__.'/../database/migrations');

        //Publish Migrations
        $this->publishes([
           __DIR__.'/../database/migrations' => database_path('migrations'),
        ], 'filament-blog-migrations');
        //Register views
        $this->loadViewsFrom(__DIR__.'/../resources/views', 'filament-blog');

        //Publish Views
        $this->publishes([
           __DIR__.'/../resources/views' => resource_path('views/vendor/filament-blog'),
        ], 'filament-blog-views');

        //Register Langs
        $this->loadTranslationsFrom(__DIR__.'/../resources/lang', 'filament-blog');

        //Publish Lang
        $this->publishes([
           __DIR__.'/../resources/lang' => base_path('lang/vendor/filament-blog'),
        ], 'filament-blog-lang');

        //Register Routes
        $this->loadRoutesFrom(__DIR__.'/../routes/web.php');

        $this->loadViewComponentsAs('cms', [
            Components\MainButton::class,
            Components\SubButton::class,
            Components\SocailIcon::class,
            Components\MenuItem::class,
            Components\OpenSourceCard::class,
            Components\BlogCard::class,
            Components\PortfolioCard::class,
            Components\SocialShare::class,
            Components\ServiceCard::class,
            Components\FilterToolbar::class,
            Components\EmptyState::class,
            Components\UserMenu::class,
            Components\CommentLog::class,
            Components\LikeLog::class,
            Components\ApplicationLogo::class
        ]);

        Livewire::component('cms-like', LikePost::class);
        Livewire::component('cms-comment', CommentPost::class);

    }

    public function boot(): void
    {
        //you boot methods here
    }
}
