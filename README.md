![Screenshot](https://raw.githubusercontent.com/tomatophp/filament-blog/master/arts/3x1io-tomato-blog.jpg)

# Filament Blog Template

[![Latest Stable Version](https://poser.pugx.org/tomatophp/filament-blog/version.svg)](https://packagist.org/packages/tomatophp/filament-blog)
[![License](https://poser.pugx.org/tomatophp/filament-blog/license.svg)](https://packagist.org/packages/tomatophp/filament-blog)
[![Downloads](https://poser.pugx.org/tomatophp/filament-blog/d/total.svg)](https://packagist.org/packages/tomatophp/filament-blog)

Frontend for CMS Builder to build a blog and personal websites

## Screenshots

![Home](https://raw.githubusercontent.com/tomatophp/filament-blog/master/arts/home-light.png)
![Home Dark](https://raw.githubusercontent.com/tomatophp/filament-blog/master/arts/home-dark.png)
![Blog](https://raw.githubusercontent.com/tomatophp/filament-blog/master/arts/blog-light.png)
![Blog Dark](https://raw.githubusercontent.com/tomatophp/filament-blog/master/arts/blog-dark.png)
![Post with likes and comments](https://raw.githubusercontent.com/tomatophp/filament-blog/master/arts/post-light.png)
![Post with likes and comments Dark](https://raw.githubusercontent.com/tomatophp/filament-blog/master/arts/post-dark.png)
![Open Source](https://raw.githubusercontent.com/tomatophp/filament-blog/master/arts/open-source-light.png)
![Open Source Dark](https://raw.githubusercontent.com/tomatophp/filament-blog/master/arts/open-source-dark.png)
![Portfolios](https://raw.githubusercontent.com/tomatophp/filament-blog/master/arts/portfolios-light.png)
![Portfolios Dark](https://raw.githubusercontent.com/tomatophp/filament-blog/master/arts/portfolios-dark.png)
![Admin posts](https://raw.githubusercontent.com/tomatophp/filament-blog/master/arts/admin-posts-light.png)
![Admin posts Dark](https://raw.githubusercontent.com/tomatophp/filament-blog/master/arts/admin-posts-dark.png)

## Features

- [x] Tailwind CSS Blog Template
- [x] Blog
- [x] Open Source projects
- [x] Portfolios
- [x] Services
- [x] Contact Us
- [x] User Dashboard
- [x] Comments
- [x] Likes
- [x] SEO Friendly
- [x] Multi Language
- [x] Dark/Light Mode
- [ ] Social Login
- [ ] RSS Feed
- [ ] Sitemap

## Compatibility

| Filament Blog | Filament | Laravel | PHP  |
|---------------|----------|---------|------|
| 5.x           | 5.x      | 12 / 13 | 8.2+ |
| 1.x           | 3.x      | 10 / 11 | 8.1+ |

The frontend is built on [filament-cms](https://github.com/tomatophp/filament-cms), [filament-accounts](https://github.com/tomatophp/filament-accounts), [filament-menus](https://github.com/tomatophp/filament-menus), [filament-seo](https://github.com/tomatophp/filament-seo), [filament-settings-hub](https://github.com/tomatophp/filament-settings-hub) and [filament-types](https://github.com/tomatophp/filament-types) (all `^5.0`), they are installed with this package.

## Installation

```bash
composer require tomatophp/filament-blog
```

publish the media library migration (used by the CMS and accounts)

```bash
php artisan vendor:publish --provider="Spatie\MediaLibrary\MediaLibraryServiceProvider" --tag="medialibrary-migrations"
```

now run the install command, it runs the install commands of the packages above, migrates, publishes the frontend assets and creates the header menu

```bash
php artisan filament-blog:install
```

the command never overwrites your `package.json`, `vite.config.js` or `resources/css/app.css`. Add the blog stylesheet to your Vite input and build it

```js
// vite.config.js
laravel({
    input: [
        'resources/css/app.css',
        'resources/js/app.js',
        'resources/css/filament-blog/app.css',
    ],
    refresh: true,
}),
```

```bash
npm i -D @tailwindcss/typography @tailwindcss/forms
npm run build
```

pages still render before the build, they only miss the styles.

### Admin panel

register the plugin on `app/Providers/Filament/AdminPanelProvider.php`, it also registers the CMS, settings hub, SEO, menus and accounts plugins (a plugin you already registered on the panel keeps your own configuration)

```php
->plugin(\TomatoPHP\FilamentBlog\FilamentBlogPlugin::make())
```

### User panel

visitors sign in to like and comment. Create a panel for them

```bash
php artisan filament:panel app
```

and use the `accounts` guard with the blog user panel plugin (comments, likes and a stats widget)

```php
use TomatoPHP\FilamentBlog\FilamentBlogUserPanelPlugin;

$panel
    ->id('app')
    ->path('app')
    ->login()
    ->registration()
    ->authGuard('accounts')
    ->plugin(FilamentBlogUserPanelPlugin::make());
```

outside the `local` environment Filament only lets models that implement `FilamentUser` into a panel, so publish the account model (`php artisan vendor:publish --tag="filament-accounts-model"`, then set `filament-accounts.model`) and allow the user panel only

```php
use Filament\Models\Contracts\FilamentUser;
use Filament\Panel;

class Account extends Authenticatable implements FilamentUser, HasAvatar, HasMedia
{
    public function canAccessPanel(Panel $panel): bool
    {
        return $panel->getId() === 'app' && $this->is_active;
    }
}
```

the `accounts` guard is registered by the package with the `filament-accounts.model` model (`TomatoPHP\FilamentAccounts\Models\Account` by default) when your `config/auth.php` does not define it, so you do not need to add it yourself. If you use another panel id, change `user-panel` in `config/filament-blog.php`.

## Frontend routes

the frontend is served per locale: `/en`, `/en/blog`, `/en/blog/{slug}`, `/en/open-source`, `/en/portfolios`, `/en/services`, `/en/contact` and CMS pages on `/en/{slug}`. `/` redirects to the default locale.

Laravel apps ship a `/` route in `routes/web.php` and it wins over the blog redirect, so either remove it or mount the blog under a prefix

```dotenv
# serve the blog on /site/en/...
FILAMENT_BLOG_PREFIX=site

# or do not register the frontend routes at all
FILAMENT_BLOG_ROUTES=false
```

```php
// config/filament-blog.php
'routes' => [
    'enabled' => env('FILAMENT_BLOG_ROUTES', true),
    'prefix' => env('FILAMENT_BLOG_PREFIX', ''),
    'redirect_root' => true,
    'middleware' => ['web'],
],
```

the content comes from the CMS posts: type `post` for the blog, `open-source`, `portfolio`, `service` and `page`; only published posts are shown.

## Publish Assets

you can publish config file by use this command

```bash
php artisan vendor:publish --tag="filament-blog-config"
```

you can publish views file by use this command

```bash
php artisan vendor:publish --tag="filament-blog-views"
```

you can publish languages file by use this command

```bash
php artisan vendor:publish --tag="filament-blog-lang"
```

you can publish migrations file by use this command

```bash
php artisan vendor:publish --tag="filament-blog-migrations"
```

you can publish the frontend css and js by use this command

```bash
php artisan vendor:publish --tag="filament-blog-assets"
```

## Upgrading from v1

- comments now use `TomatoPHP\FilamentBlog\Models\Comment` on the same `comments` table, existing comments keep working.
- the `InteractsWithBlog` trait on your account model is optional now; likes and comments go through `TomatoPHP\FilamentBlog\Services\Interactions`.
- the stylesheet moved to `resources/css/filament-blog/app.css` (Tailwind v4), see the installation steps above.

## Testing

```bash
composer test
```

## Other Filament Packages

Checkout our [Awesome TomatoPHP](https://github.com/tomatophp/awesome)
