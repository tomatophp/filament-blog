<?php

namespace TomatoPHP\FilamentBlog;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Vite;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\HtmlString;
use TomatoPHP\FilamentAccounts\Models\Account;
use TomatoPHP\FilamentCms\Models\Post;

class FilamentBlog
{
    /**
     * @return array<string, array{name?: string, locale?: string, rtl?: bool}>
     */
    public static function locales(): array
    {
        $locales = config('filament-blog.locals');

        if (! is_array($locales) || $locales === []) {
            return ['en' => ['name' => 'English', 'locale' => 'en', 'rtl' => false]];
        }

        return $locales;
    }

    /**
     * The locale the root redirect lands on: the app locale when the blog supports it, otherwise the first configured one.
     */
    public static function defaultLocale(): string
    {
        $locales = array_keys(static::locales());
        $appLocale = (string) config('app.locale');

        return in_array($appLocale, $locales, true) ? $appLocale : (string) $locales[0];
    }

    public static function currentLocale(): string
    {
        $locale = app()->getLocale();

        return array_key_exists($locale, static::locales()) ? $locale : static::defaultLocale();
    }

    public static function isRtl(?string $locale = null): bool
    {
        return (bool) (static::locales()[$locale ?? static::currentLocale()]['rtl'] ?? false);
    }

    /**
     * Build a frontend URL: {prefix}/{locale}/{path}.
     */
    public static function url(string $path = '', ?string $locale = null): string
    {
        $segments = array_filter([
            trim((string) config('filament-blog.routes.prefix'), '/'),
            $locale ?? static::currentLocale(),
            trim($path, '/'),
        ], fn (string $segment): bool => $segment !== '');

        return url(implode('/', $segments));
    }

    /**
     * The public URL of a CMS post, based on its type.
     */
    public static function postUrl(Post $post, ?string $locale = null): string
    {
        $section = match ($post->type) {
            'open-source' => 'open-source/',
            'portfolio' => 'portfolios/',
            'service' => 'services/',
            'page' => '',
            default => 'blog/',
        };

        return static::url($section.$post->slug, $locale);
    }

    /**
     * The current page in the next configured locale, or null when the current route is not a blog route.
     */
    public static function localeSwitchUrl(): ?string
    {
        $route = request()->route();
        $name = $route?->getName();
        $locales = array_keys(static::locales());
        $current = static::currentLocale();

        if (! $name || count($locales) < 2 || ! str_starts_with($name, $current.'.')) {
            return null;
        }

        $next = $locales[(array_search($current, $locales, true) + 1) % count($locales)];
        $targetName = $next.substr($name, strlen($current));

        if (! Route::has($targetName)) {
            return null;
        }

        return route($targetName, $route->parameters());
    }

    public static function guard(): string
    {
        return (string) config('filament-blog.guard', 'accounts');
    }

    /**
     * The account signed in on the frontend guard.
     */
    public static function account(): ?Model
    {
        $user = auth(static::guard())->user();

        return $user instanceof Model ? $user : null;
    }

    /**
     * @return class-string<Model>
     */
    public static function accountModel(): string
    {
        return config('filament-accounts.model') ?: Account::class;
    }

    /**
     * Vite tags for the configured entries; entries that are not built yet are skipped so the pages still render.
     */
    public static function vite(): HtmlString
    {
        $entries = array_values(array_filter(
            (array) config('filament-blog.vite', []),
            fn (mixed $entry): bool => is_string($entry) && static::viteEntryExists($entry),
        ));

        if ($entries === []) {
            return new HtmlString('');
        }

        return app(Vite::class)($entries);
    }

    protected static function viteEntryExists(string $entry): bool
    {
        if (is_file(app(Vite::class)->hotFile())) {
            return true;
        }

        $manifestPath = public_path('build/manifest.json');

        if (! is_file($manifestPath)) {
            return false;
        }

        $manifest = json_decode((string) file_get_contents($manifestPath), true);

        return is_array($manifest) && array_key_exists($entry, $manifest);
    }
}
