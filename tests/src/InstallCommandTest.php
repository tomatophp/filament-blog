<?php

use Illuminate\Support\Facades\File;
use TomatoPHP\FilamentMenus\Models\Menu;

afterEach(function () {
    File::deleteDirectory(resource_path('css/filament-blog'));
    File::delete(config_path('markdown.php'));
    File::delete(public_path('js/highlight.min.js'));
    File::delete(public_path('js/jquery-3.7.1.min.js'));
    File::deleteDirectory(public_path('js/languages'));
});

it('installs the frontend assets and the header menu', function () {
    $this->artisan('filament-blog:install', ['--skip-dependencies' => true])->assertSuccessful();

    $menu = Menu::query()->where('key', 'header')->firstOrFail();

    expect($menu->menuItems()->count())->toBe(4)
        ->and(File::exists(resource_path('css/filament-blog/app.css')))->toBeTrue()
        ->and(File::exists(public_path('js/highlight.min.js')))->toBeTrue()
        ->and(File::exists(config_path('markdown.php')))->toBeTrue();
});

it('can run twice without duplicating the menu or overwriting customised assets', function () {
    $this->artisan('filament-blog:install', ['--skip-dependencies' => true])->assertSuccessful();

    File::put(resource_path('css/filament-blog/app.css'), '/* customised */');

    $this->artisan('filament-blog:install', ['--skip-dependencies' => true])->assertSuccessful();

    expect(Menu::query()->where('key', 'header')->count())->toBe(1)
        ->and(File::get(resource_path('css/filament-blog/app.css')))->toBe('/* customised */');
});

it('shows the menu items in the frontend header', function () {
    $this->artisan('filament-blog:install', ['--skip-dependencies' => true])->assertSuccessful();

    $this->get('/en')->assertOk()->assertSee('Open Source')->assertSee(url('en/open-source'), false);
    $this->get('/ar')->assertOk()->assertSee('مفتوح المصدر');
});

it('imports the legacy stylesheets into a cascade layer so tailwind utilities win', function () {
    $css = file_get_contents(__DIR__.'/../../publish/resources/css/filament-blog/app.css');

    expect($css)
        ->toContain('@import "./style.css" layer(components);')
        ->toContain('@import "./github-dark.min.css" layer(components);')
        ->not->toMatch('/@import "\.\/style\.css";/');
});
