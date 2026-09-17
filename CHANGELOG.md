# Changelog

## v5.0.0

- support Filament v5, Livewire 4 and Laravel 12 / 13 (PHP 8.2+)
- fix the frontend not rendering: every page failed on Laravel 12+ because the JSON-LD `"@context"` in the meta partial compiled as the new `@context` Blade directive
- fix the frontend failing with "Auth guard [accounts] is not defined": the package now registers the `accounts` guard (using the filament-accounts model) when the app has not defined it
- fix CMS pages (`/{locale}/{page}`) pointing at a missing controller method
- `FilamentBlogPlugin` only registers the CMS, settings hub, SEO, menus and accounts plugins the panel does not already have, so their own configuration is kept
- the published stylesheet imports the legacy `style.css` and `github-dark.min.css` into the `components` layer; unlayered they overrode Tailwind 4 utilities, so the menu filled the screen and the page content was pushed below it. Apps that already published `resources/css/filament-blog/app.css` should add `layer(components)` to both imports
- the `/` redirect falls back to the first configured locale when the app locale is not a blog locale
- pages render before `npm run build`: Vite entries missing from the manifest are skipped
- new `routes` config: `enabled`, `prefix`, `redirect_root` and `middleware`, so the frontend can live next to an existing `/` route
- comments are owned by this package (`TomatoPHP\FilamentBlog\Models\Comment`, same `comments` table schema as older filament-cms releases) because filament-cms v5 no longer ships them
- likes, comments and activity logs work with any account model through `TomatoPHP\FilamentBlog\Services\Interactions`; the host `App\Models\Account` / `App\Models\AccountLog` classes are no longer required
- fix unliking a post decrementing the counter twice
- show pages only serve published posts of the matching type and return 404 for unknown slugs
- the like and comment components use `FilamentBlog::account()`, so edit/delete only ever touch the signed in account's own comments
- the install command no longer overwrites `package.json`, `vite.config.js`, `tailwind.config.js` or `resources/css/app.css`; it publishes a Tailwind v4 entry to `resources/css/filament-blog/app.css` and skips files that already exist (`--force` to overwrite)
- drop the unused `laravel/jetstream` and `tomatophp/console-helpers` dependencies
- add a Pest test suite and the Laravel 12 / 13 test matrix

## v1.0.0

First release of the package
