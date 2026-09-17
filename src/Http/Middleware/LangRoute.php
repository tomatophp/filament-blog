<?php

namespace TomatoPHP\FilamentBlog\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use Symfony\Component\HttpFoundation\Response;
use TomatoPHP\FilamentBlog\FilamentBlog;

class LangRoute
{
    /**
     * Set the app locale from the locale route group the request matched.
     *
     * @param  Closure(Request):Response  $next
     */
    public function handle(Request $request, Closure $next, ?string $locale = null): Response
    {
        $locales = FilamentBlog::locales();

        if ($locale && array_key_exists($locale, $locales)) {
            app()->setLocale($locale);

            if (! $request->hasCookie('lang')) {
                Cookie::queue('lang', json_encode([
                    'id' => $locale,
                    'name' => $locales[$locale]['name'] ?? $locale,
                ]), 60 * 24 * 30);
            }

            $account = FilamentBlog::account();

            if ($account && array_key_exists('lang', $account->getAttributes()) && $account->getAttribute('lang') !== $locale) {
                $account->forceFill(['lang' => $locale])->saveQuietly();
            }
        }

        return $next($request);
    }
}
