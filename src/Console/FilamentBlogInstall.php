<?php

namespace TomatoPHP\FilamentBlog\Console;

use Illuminate\Console\Command;
use TomatoPHP\ConsoleHelpers\Traits\HandleFiles;
use TomatoPHP\ConsoleHelpers\Traits\RunCommand;
use TomatoPHP\FilamentMenus\Models\Menu;

class FilamentBlogInstall extends Command
{
    use RunCommand;
    use HandleFiles;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $name = 'filament-blog:install';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'install package and publish assets';

    public function __construct()
    {
        parent::__construct();
    }


    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->info('Publish Vendor Assets');

        $this->artisanCommand(['migrate']);

        $this->copyFile(
            from: __DIR__ . '/../../publish/js',
            to: public_path('js'),
            type: "folder"
        );

        $this->copyFile(
            from: __DIR__ . '/../../publish/resources/css',
            to: resource_path('css'),
            type: "folder"
        );

        $this->copyFile(
            from: __DIR__ . '/../../publish/config/markdown.php',
            to: config_path('markdown.php')
        );

        $this->copyFile(
            from: __DIR__ . '/../../publish/package.json',
            to: base_path('package.json')
        );

        $this->copyFile(
            from: __DIR__ . '/../../publish/postcss.config.js',
            to: base_path('postcss.config.js')
        );

        $this->copyFile(
            from: __DIR__ . '/../../publish/tailwind.config.js',
            to: base_path('tailwind.config.js')
        );

        $this->copyFile(
            from: __DIR__ . '/../../publish/vite.config.js',
            to: base_path('vite.config.js')
        );
        $this->info('Generate Menu');

        $menu = Menu::query()->where('key', 'header')->first();
        if(!$menu){
            $menu = Menu::query()->create([
                "title" => "Header",
                "key" => "header",
                "location" => "header",
                "activated" => 1
            ]);

            $menu->menuItems()->createMany([
                [
                    "title" => [
                        "ar" => "المدونة",
                        "en" => "Blog"
                    ],
                    "is_route" => false,
                    "has_badge" => false,
                    "url" => "blog",
                    "icon" => "heroicon-c-link",
                    "order" => 1,
                ],
                [
                    "title" => [
                        "ar" => "مفتوح المصدر",
                        "en" => "Open Source"
                    ],
                    "is_route" => false,
                    "has_badge" => false,
                    "url" => "open-source",
                    "icon" => "heroicon-c-link",
                    "order" => 2,
                ],
                [
                    "title" => [
                        "ar" => "الخدمات",
                        "en" => "Services"
                    ],
                    "is_route" => false,
                    "has_badge" => false,
                    "url" => "services",
                    "icon" => "heroicon-c-link",
                    "order" => 3,
                ],
                [
                    "title" => [
                        "ar" => "معرض الاعمال",
                        "en" => "Portfolios"
                    ],
                    "is_route" => false,
                    "has_badge" => false,
                    "url" => "portfolios",
                    "icon" => "heroicon-c-link",
                    "order" => 4,
                ]
            ]);
        }


        $this->info('Clean Up');
        $this->artisanCommand(['optimize']);
        $this->artisanCommand(['filament:optimize-clear']);
        $this->artisanCommand(['icon:cache']);

        $this->info('Filament Blog installed successfully.');
        $this->info('please run npm i && npm run build');
    }
}
