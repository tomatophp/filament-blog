<?php

use Illuminate\Support\Facades\Route;
use TomatoPHP\FilamentBlog\FilamentBlog;
use TomatoPHP\FilamentBlog\Http\Controllers\AuthController;
use TomatoPHP\FilamentBlog\Http\Controllers\BlogController;
use TomatoPHP\FilamentBlog\Http\Controllers\ContactUsController;
use TomatoPHP\FilamentBlog\Http\Controllers\OpenSourceController;
use TomatoPHP\FilamentBlog\Http\Controllers\PageController;
use TomatoPHP\FilamentBlog\Http\Controllers\PortfolioController;
use TomatoPHP\FilamentBlog\Http\Controllers\ServiceController;
use TomatoPHP\FilamentBlog\Http\Middleware\LangRoute;

$prefix = trim((string) config('filament-blog.routes.prefix'), '/');

Route::middleware(config('filament-blog.routes.middleware', ['web']))
    ->prefix($prefix)
    ->group(function () {
        if (config('filament-blog.routes.redirect_root', true)) {
            Route::get('/', fn () => redirect()->to(FilamentBlog::url('', FilamentBlog::defaultLocale())))->name('index');
        }

        foreach (array_keys(FilamentBlog::locales()) as $locale) {
            Route::prefix($locale)
                ->name($locale.'.')
                ->middleware(LangRoute::class.':'.$locale)
                ->group(function () {
                    Route::name('auth.')->group(function () {
                        Route::get('/login', [AuthController::class, 'login'])->name('login');
                        Route::get('/register', [AuthController::class, 'register'])->name('register');
                    });

                    Route::get('/', [PageController::class, 'index'])->name('home.index');

                    Route::get('/contact', [ContactUsController::class, 'index'])->name('contact.index');

                    Route::name('open-source.')->prefix('open-source')->group(function () {
                        Route::get('/', [OpenSourceController::class, 'index'])->name('index');
                        Route::get('/{docs}', [OpenSourceController::class, 'show'])->name('show');
                    });

                    Route::name('portfolios.')->prefix('portfolios')->group(function () {
                        Route::get('/', [PortfolioController::class, 'index'])->name('index');
                        Route::get('/{portfolio}', [PortfolioController::class, 'show'])->name('show');
                    });

                    Route::name('blog.')->prefix('blog')->group(function () {
                        Route::get('/', [BlogController::class, 'index'])->name('index');
                        Route::get('/{post}', [BlogController::class, 'show'])->name('show');
                    });

                    Route::name('services.')->prefix('services')->group(function () {
                        Route::get('/', [ServiceController::class, 'index'])->name('index');
                        Route::get('/{service}', [ServiceController::class, 'show'])->name('show');
                    });

                    Route::get('/{page}', [PageController::class, 'show'])->name('home.page');
                });
        }
    });
