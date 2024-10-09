<!doctype html >
<html class="dark motion-safe:scroll-smooth 2xl:text-[20px]" lang="{{ app()->getLocale() }}" dir="{{ app()->getLocale() === 'ar' ? 'rtl' : 'ltr' }}">
<head>
    @include('filament-blog::parts.meta')
    @include('filament-blog::parts.css')
</head>
<body class="hidden app antialiased text-gray-900 dark:text-slate-300 tracking-tight bg-white dark:bg-slate-950 ibm-plex-sans-arabic-medium">
    @include('filament-blog::parts.header')
    <main>
        @yield('body')
    </main>

    @include('filament-blog::parts.footer')
    @include('filament-blog::parts.js')
</body>
</html>
