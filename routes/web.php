<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

use Illuminate\Support\Facades\Route;

Route::middleware(['web'])->group(function () {
    Route::get('/', function () {
        return redirect()->to('/' . app()->getLocale());
    })->middleware(['web'])->name('index');

    foreach (config('filament-blog.locals') as $local=>$locals){
        Route::prefix($local)->name($local .'.')->middleware(['web', \TomatoPHP\FilamentBlog\Http\Middleware\LangRoute::class])->group(function () use ($local) {
            Route::name('auth.')->group(function () {
                Route::get('/login', [\TomatoPHP\FilamentBlog\Http\Controllers\AuthController::class, 'login'])->name('login');
                Route::get('/register', [\TomatoPHP\FilamentBlog\Http\Controllers\AuthController::class, 'register'])->name('register');
                Route::get('/verify-otp', [\TomatoPHP\FilamentBlog\Http\Controllers\AuthController::class, 'otp'])->name('otp');
            });

            Route::name('home.')->group(function () {
                Route::get('/', [\TomatoPHP\FilamentBlog\Http\Controllers\PageController::class, 'index'])->name('index');
            });

            Route::name('contact.')->prefix('contact')->group(function () {
                Route::get('/', [\TomatoPHP\FilamentBlog\Http\Controllers\ContactUsController::class, 'index'])->name('index');
            });

            Route::name('open-source.')->prefix('open-source')->group(function () {
                Route::get('/', [\TomatoPHP\FilamentBlog\Http\Controllers\OpenSourceController::class, 'index'])->name('index');
                Route::get('/{docs}', [\TomatoPHP\FilamentBlog\Http\Controllers\OpenSourceController::class, 'show'])->name('show');
            });

            Route::name('portfolios.')->prefix('portfolios')->group(function () {
                Route::get('/', [\TomatoPHP\FilamentBlog\Http\Controllers\PortfolioController::class, 'index'])->name('index');
                Route::get('/{portfolio}', [\TomatoPHP\FilamentBlog\Http\Controllers\PortfolioController::class, 'show'])->name('show');
            });

            Route::name('blog.')->prefix('blog')->group(function () {
                Route::get('/', [\TomatoPHP\FilamentBlog\Http\Controllers\BlogController::class, 'index'])->name('index');
                Route::get('/{post}', [\TomatoPHP\FilamentBlog\Http\Controllers\BlogController::class, 'show'])->name('show');
            });

            Route::name('services.')->prefix('services')->group(function () {
                Route::get('/', [\TomatoPHP\FilamentBlog\Http\Controllers\ServiceController::class, 'index'])->name('index');
                Route::get('/{service}', [\TomatoPHP\FilamentBlog\Http\Controllers\ServiceController::class, 'show'])->name('show');
            });

            Route::name('home.')->group(function () {
                Route::get('/{page}', [\TomatoPHP\FilamentBlog\Http\Controllers\PageController::class, 'page'])->name('page');
            });

        });
    }
});
