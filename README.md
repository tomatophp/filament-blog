![Screenshot](https://raw.githubusercontent.com/tomatophp/filament-blog/master/arts/3x1io-tomato-blog.jpg)

# Filament Blog Template

[![Latest Stable Version](https://poser.pugx.org/tomatophp/filament-blog/version.svg)](https://packagist.org/packages/tomatophp/filament-blog)
[![License](https://poser.pugx.org/tomatophp/filament-blog/license.svg)](https://packagist.org/packages/tomatophp/filament-blog)
[![Downloads](https://poser.pugx.org/tomatophp/filament-blog/d/total.svg)](https://packagist.org/packages/tomatophp/filament-blog)

Frontend for CMS Builder to build a blog and personal websites

## Screenshots

![Home](https://raw.githubusercontent.com/tomatophp/filament-blog/master/arts/home.png)
![Blog](https://raw.githubusercontent.com/tomatophp/filament-blog/master/arts/blog.png)
![Post](https://raw.githubusercontent.com/tomatophp/filament-blog/master/arts/post.png)
![Like & Comments](https://raw.githubusercontent.com/tomatophp/filament-blog/master/arts/share-comments.png)
![Open Source](https://raw.githubusercontent.com/tomatophp/filament-blog/master/arts/open-source.png)
![Portfolios](https://raw.githubusercontent.com/tomatophp/filament-blog/master/arts/portfolios.png)
![Services](https://raw.githubusercontent.com/tomatophp/filament-blog/master/arts/services.png)
![Contact](https://raw.githubusercontent.com/tomatophp/filament-blog/master/arts/contact.png)
![User Dashboard](https://raw.githubusercontent.com/tomatophp/filament-blog/master/arts/user-dashboard.png)
![Comments](https://raw.githubusercontent.com/tomatophp/filament-blog/master/arts/comments.png)
![Likes](https://raw.githubusercontent.com/tomatophp/filament-blog/master/arts/likes.png)


## Features

- [x] Tailwind CSS Blog Template
- [x] Blog
- [x] Open Source integration with GitHub / Composer
- [x] Portfolios integration with Behanace
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

## Installation

```bash
composer require tomatophp/filament-blog
```

we need to publish some migrations for settings and media

```bash
php artisan vendor:publish --provider="Spatie\MediaLibrary\MediaLibraryServiceProvider" --tag="medialibrary-migrations"
```

```bash
php artisan vendor:publish --provider="Spatie\LaravelSettings\LaravelSettingsServiceProvider" --tag="migrations"
```

if you are using this package as a plugin please register the plugin on `/app/Providers/Filament/AdminPanelProvider.php`

```php
->plugin(\TomatoPHP\FilamentBlog\FilamentBlogPlugin::make())
```

now you need to create a user panel you can follow instructions on [filament-accounts](https://www.github.com/tomatophp/filament-accounts)

let's start by create a new panel

```bash
php artisan filament:panel app
```

if you need to change the panel name you can change it on config file `filament-blog.php`

```php

return [
    "user-panel" => "app"
];
```

inside the new panel add this plugin

```php
->plugin(
    FilamentBlogUserPanelPlugin::make()
)
```

and if you don't setup the full user panel use it like this

```php
->plugin(
    FilamentAccountsSaaSPlugin::make()
        ->editProfile()
        ->editProfileMenu()
        ->APITokenManager()
        ->browserSesstionManager()
        ->deleteAccount()
        ->editPassword()
        ->registration()
        ->checkAccountStatusInLogin()
)
```

now it's time to install

```bash
php artisan filament-blog:install
```

after install please run npm

```bash
npm i && npm run build
```

now you can visit your website and you will see the blog

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

## Other Filament Packages

Checkout our [Awesome TomatoPHP](https://github.com/tomatophp/awesome)
