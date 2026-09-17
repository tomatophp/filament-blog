<?php

namespace TomatoPHP\FilamentBlog;

use Illuminate\Support\ServiceProvider;
use Livewire\Livewire;
use TomatoPHP\FilamentBlog\Console\FilamentBlogInstall;
use TomatoPHP\FilamentBlog\Livewire\CommentPost;
use TomatoPHP\FilamentBlog\Livewire\LikePost;
use TomatoPHP\FilamentBlog\View\Components\ApplicationLogo;
use TomatoPHP\FilamentBlog\View\Components\BlogCard;
use TomatoPHP\FilamentBlog\View\Components\CommentLog;
use TomatoPHP\FilamentBlog\View\Components\EmptyState;
use TomatoPHP\FilamentBlog\View\Components\FilterToolbar;
use TomatoPHP\FilamentBlog\View\Components\LikeLog;
use TomatoPHP\FilamentBlog\View\Components\MainButton;
use TomatoPHP\FilamentBlog\View\Components\MenuItem;
use TomatoPHP\FilamentBlog\View\Components\OpenSourceCard;
use TomatoPHP\FilamentBlog\View\Components\PortfolioCard;
use TomatoPHP\FilamentBlog\View\Components\ProfileCard;
use TomatoPHP\FilamentBlog\View\Components\ServiceCard;
use TomatoPHP\FilamentBlog\View\Components\SocailIcon;
use TomatoPHP\FilamentBlog\View\Components\SocialShare;
use TomatoPHP\FilamentBlog\View\Components\SubButton;
use TomatoPHP\FilamentBlog\View\Components\UserMenu;

class FilamentBlogServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->mergeConfigFrom(__DIR__.'/../config/filament-blog.php', 'filament-blog');

        $this->commands([
            FilamentBlogInstall::class,
        ]);

        $this->app->booting(function (): void {
            $this->registerAccountsGuard();
            $this->disableServerSideCodeHighlighting();
        });
    }

    public function boot(): void
    {
        $this->publishes([
            __DIR__.'/../config/filament-blog.php' => config_path('filament-blog.php'),
        ], 'filament-blog-config');

        $this->loadMigrationsFrom(__DIR__.'/../database/migrations');

        $this->publishes([
            __DIR__.'/../database/migrations' => database_path('migrations'),
        ], 'filament-blog-migrations');

        $this->loadViewsFrom(__DIR__.'/../resources/views', 'filament-blog');

        $this->publishes([
            __DIR__.'/../resources/views' => resource_path('views/vendor/filament-blog'),
        ], 'filament-blog-views');

        $this->loadTranslationsFrom(__DIR__.'/../resources/lang', 'filament-blog');

        $this->publishes([
            __DIR__.'/../resources/lang' => base_path('lang/vendor/filament-blog'),
        ], 'filament-blog-lang');

        $this->publishes([
            __DIR__.'/../publish/resources/css/filament-blog' => resource_path('css/filament-blog'),
            __DIR__.'/../publish/js' => public_path('js'),
        ], 'filament-blog-assets');

        if (config('filament-blog.routes.enabled', true)) {
            $this->loadRoutesFrom(__DIR__.'/../routes/web.php');
        }

        $this->loadViewComponentsAs('cms', [
            MainButton::class,
            SubButton::class,
            SocailIcon::class,
            MenuItem::class,
            OpenSourceCard::class,
            BlogCard::class,
            PortfolioCard::class,
            SocialShare::class,
            ServiceCard::class,
            FilterToolbar::class,
            EmptyState::class,
            UserMenu::class,
            CommentLog::class,
            LikeLog::class,
            ApplicationLogo::class,
            ProfileCard::class,
        ]);

        Livewire::component('cms-like', LikePost::class);
        Livewire::component('cms-comment', CommentPost::class);
    }

    /**
     * The frontend reads the signed in account from the "accounts" guard. Register it when the host app
     * has not defined it, so the pages do not fail with "Auth guard [accounts] is not defined".
     */
    protected function registerAccountsGuard(): void
    {
        $guard = FilamentBlog::guard();

        if (! config("auth.providers.{$guard}")) {
            config()->set("auth.providers.{$guard}", [
                'driver' => 'eloquent',
                'model' => FilamentBlog::accountModel(),
            ]);
        }

        if (! config("auth.guards.{$guard}")) {
            config()->set("auth.guards.{$guard}", [
                'driver' => 'session',
                'provider' => $guard,
            ]);
        }
    }

    /**
     * The frontend highlights code in the browser. Without a published markdown config, spatie/laravel-markdown
     * would shell out to Shiki (Node) for every fenced code block.
     */
    protected function disableServerSideCodeHighlighting(): void
    {
        if (! file_exists(config_path('markdown.php'))) {
            config()->set('markdown.code_highlighting.enabled', false);
        }
    }
}
