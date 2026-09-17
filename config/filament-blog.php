<?php

return [
    /*
     * Frontend locales. Every key becomes a URL segment (/en, /ar, ...).
     */
    'locals' => [
        'en' => [
            'name' => 'English',
            'locale' => 'en',
            'rtl' => false,
        ],
        'ar' => [
            'name' => 'العربية',
            'locale' => 'ar',
            'rtl' => true,
        ],
    ],

    /*
     * Frontend routes.
     *
     * enabled:       register the blog frontend routes at all.
     * prefix:        mount the frontend under a path, e.g. "site" gives /site/en/blog.
     *                Leave empty to serve it from the site root (/en/blog).
     * redirect_root: register a route on the prefix root (or "/") that redirects to the default locale.
     *                A "/" route defined in the host routes/web.php always wins over this one,
     *                so remove it from the host app (or set a prefix) to land on the blog.
     * middleware:    middleware applied to every frontend route.
     */
    'routes' => [
        'enabled' => env('FILAMENT_BLOG_ROUTES', true),
        'prefix' => env('FILAMENT_BLOG_PREFIX', ''),
        'redirect_root' => true,
        'middleware' => ['web'],
    ],

    /*
     * The user panel id/path used for login, registration and the account dashboard.
     */
    'user-panel' => 'app',

    /*
     * The admin panel path used in the database notifications sent to post authors.
     */
    'admin-panel' => 'admin',

    /*
     * Send a Filament database notification to the post author on every like and comment.
     * Needs the notifications table and a Notifiable author model.
     */
    'notify_authors' => true,

    /*
     * The auth guard used by frontend accounts. When it is not defined in config/auth.php
     * the package registers a session guard for it using the filament-accounts model.
     */
    'guard' => 'accounts',

    /*
     * Vite entries loaded by the frontend layout. Entries missing from the Vite manifest are skipped,
     * so the pages still render before `npm run build`.
     */
    'vite' => [
        'resources/css/filament-blog/app.css',
    ],
];
