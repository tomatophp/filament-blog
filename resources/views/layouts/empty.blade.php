<!doctype html >
<html class="dark motion-safe:scroll-smooth 2xl:text-[20px]" lang="{{ app()->getLocale() }}" dir="{{ app()->getLocale() === 'ar' ? 'rtl' : 'ltr' }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <title>@yield('title')</title>

    @vite('resources/css/app.css')
    @stack('css')
</head>
<body class="antialiased text-gray-900 dark:text-slate-300 tracking-tight bg-white dark:bg-slate-950">

    <main>
        @yield('body')
    </main>

    @vite('resources/js/app.js')
    @stack('js')
</body>
</html>
