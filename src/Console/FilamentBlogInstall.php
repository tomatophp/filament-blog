<?php

namespace TomatoPHP\FilamentBlog\Console;

use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;
use TomatoPHP\FilamentMenus\Models\Menu;

class FilamentBlogInstall extends Command
{
    protected $signature = 'filament-blog:install
        {--skip-dependencies : Do not run the install commands of the CMS, accounts, menus, SEO, settings and types packages}
        {--force : Overwrite frontend assets that were already published}';

    protected $description = 'Install the blog frontend: migrations, frontend assets and the header menu';

    /**
     * @var list<string>
     */
    protected array $dependencies = [
        'filament-settings-hub:install',
        'filament-types:install',
        'filament-cms:install',
        'filament-accounts:install',
        'filament-menus:install',
        'filament-seo:install',
    ];

    public function handle(Filesystem $files): int
    {
        if (! $this->option('skip-dependencies')) {
            foreach ($this->dependencies as $command) {
                if ($this->getApplication()?->has($command)) {
                    $this->call($command);
                }
            }
        }

        $this->components->info('Running migrations');
        $this->call('migrate', ['--force' => true]);

        $this->components->info('Publishing frontend assets');
        $this->copyMissing($files, __DIR__.'/../../publish/js', public_path('js'));
        $this->copyMissing($files, __DIR__.'/../../publish/resources/css/filament-blog', resource_path('css/filament-blog'));

        if (! $files->exists(config_path('markdown.php'))) {
            $files->copy(__DIR__.'/../../publish/config/markdown.php', config_path('markdown.php'));
        }

        $this->components->info('Generating the header menu');
        $this->createHeaderMenu();

        $this->call('optimize:clear');

        $this->components->info('Filament Blog installed successfully.');
        $this->line('Next steps:');
        $this->line('  1. Add "resources/css/filament-blog/app.css" to the input array in vite.config.js');
        $this->line('  2. npm i -D @tailwindcss/typography @tailwindcss/forms && npm run build');
        $this->line('  3. Remove the "/" route from routes/web.php, or set FILAMENT_BLOG_PREFIX, so the blog is reachable');

        return self::SUCCESS;
    }

    /**
     * Copy every file from $from to $to, keeping files the app already has unless --force is passed.
     */
    protected function copyMissing(Filesystem $files, string $from, string $to): void
    {
        foreach ($files->allFiles($from) as $file) {
            $target = $to.DIRECTORY_SEPARATOR.$file->getRelativePathname();

            if ($files->exists($target) && ! $this->option('force')) {
                continue;
            }

            $files->ensureDirectoryExists(dirname($target));
            $files->copy($file->getPathname(), $target);
        }
    }

    protected function createHeaderMenu(): void
    {
        if (Menu::query()->where('key', 'header')->exists()) {
            return;
        }

        $menu = Menu::query()->create([
            'title' => 'Header',
            'key' => 'header',
            'location' => 'header',
            'activated' => 1,
        ]);

        $items = [
            ['url' => 'blog', 'en' => 'Blog', 'ar' => 'المدونة'],
            ['url' => 'open-source', 'en' => 'Open Source', 'ar' => 'مفتوح المصدر'],
            ['url' => 'services', 'en' => 'Services', 'ar' => 'الخدمات'],
            ['url' => 'portfolios', 'en' => 'Portfolios', 'ar' => 'معرض الاعمال'],
        ];

        foreach ($items as $order => $item) {
            $menu->menuItems()->create([
                'title' => ['en' => $item['en'], 'ar' => $item['ar']],
                'is_route' => false,
                'has_badge' => false,
                'url' => $item['url'],
                'icon' => 'heroicon-c-link',
                'order' => $order + 1,
            ]);
        }
    }
}
