<?php

use Illuminate\Support\Facades\Route;
use TomatoPHP\FilamentBlog\FilamentBlog;
use TomatoPHP\FilamentCms\Models\Post;

beforeEach(function () {
    blogPost('post', 'first-post');
    blogPost('open-source', 'filament-blog', ['meta_url' => 'https://github.com/tomatophp/filament-blog']);
    blogPost('portfolio', 'my-portfolio');
    blogPost('service', 'web-development');
    blogPost('page', 'about');
});

it('redirects the site root to the default locale', function () {
    $this->get('/')->assertRedirect('/en');
});

it('redirects the site root to the first configured locale when the app locale is not a blog locale', function () {
    config(['app.locale' => 'fr']);

    $this->get('/')->assertRedirect('/en');
});

it('renders every frontend page with seeded CMS data', function (string $uri, string $see) {
    $this->get($uri)->assertOk()->assertSee($see, false);
})->with([
    'home' => ['/en', 'blog'],
    'blog index' => ['/en/blog', 'Title of first-post'],
    'blog show' => ['/en/blog/first-post', 'Body of first-post'],
    'open source index' => ['/en/open-source', 'Title of filament-blog'],
    'open source show' => ['/en/open-source/filament-blog', 'Title of filament-blog'],
    'portfolios index' => ['/en/portfolios', 'Title of my-portfolio'],
    'portfolio show' => ['/en/portfolios/my-portfolio', 'Title of my-portfolio'],
    'services index' => ['/en/services', 'Title of web-development'],
    'service show' => ['/en/services/web-development', 'Title of web-development'],
    'contact' => ['/en/contact', 'contact'],
    'cms page' => ['/en/about', 'Body of about'],
    'arabic blog' => ['/ar/blog', 'dir="rtl"'],
]);

it('sets the app locale from the url', function () {
    $this->get('/ar/blog')->assertOk();

    expect(app()->getLocale())->toBe('ar');
});

it('returns 404 for unknown and unpublished slugs', function () {
    blogPost('post', 'draft-post', ['is_published' => false]);

    $this->get('/en/blog/missing')->assertNotFound();
    $this->get('/en/blog/draft-post')->assertNotFound();
    $this->get('/en/portfolios/missing')->assertNotFound();
    $this->get('/en/services/missing')->assertNotFound();
    $this->get('/en/missing-page')->assertNotFound();
});

it('counts post views', function () {
    $this->get('/en/blog/first-post')->assertOk();
    $this->get('/en/blog/first-post')->assertOk();

    expect(FilamentBlog::url('blog/first-post'))->toEndWith('/en/blog/first-post')
        ->and(Post::query()->where('slug', 'first-post')->value('views'))->toEqual(2);
});

it('redirects login and register to the user panel', function () {
    $this->get('/en/login')->assertRedirect(url('app/login'));
    $this->get('/en/register')->assertRedirect(url('app/register'));
});

it('keeps a host "/" route and serves the blog under a configured prefix', function () {
    Route::get('/', fn () => 'host home');

    config(['filament-blog.routes.prefix' => 'site']);
    require __DIR__.'/../../routes/web.php';
    app('router')->getRoutes()->refreshNameLookups();

    $this->get('/')->assertOk()->assertSee('host home');
    $this->get('/site')->assertRedirect('/site/en');
    $this->get('/site/en/blog')->assertOk()->assertSee('Title of first-post')->assertSee(url('site/en/blog/first-post'), false);
});
