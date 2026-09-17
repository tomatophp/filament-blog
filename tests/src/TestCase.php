<?php

namespace TomatoPHP\FilamentBlog\Tests;

use BladeUI\Heroicons\BladeHeroiconsServiceProvider;
use BladeUI\Icons\BladeIconsServiceProvider;
use Filament\Actions\ActionsServiceProvider;
use Filament\FilamentServiceProvider;
use Filament\Forms\FormsServiceProvider;
use Filament\Infolists\InfolistsServiceProvider;
use Filament\Notifications\NotificationsServiceProvider;
use Filament\QueryBuilder\QueryBuilderServiceProvider;
use Filament\Schemas\SchemasServiceProvider;
use Filament\SpatieLaravelSettingsPluginServiceProvider;
use Filament\Support\SupportServiceProvider;
use Filament\Tables\TablesServiceProvider;
use Filament\Widgets\WidgetsServiceProvider;
use Illuminate\Foundation\Testing\LazilyRefreshDatabase;
use Kirschbaum\PowerJoins\PowerJoinsServiceProvider;
use Lab404\Impersonate\ImpersonateServiceProvider;
use LaraZeus\SpatieTranslatable\SpatieTranslatableServiceProvider;
use Livewire\LivewireServiceProvider;
use MallardDuck\BladeBoxicons\BladeBoxiconsServiceProvider;
use Orchestra\Testbench\Attributes\WithEnv;
use Orchestra\Testbench\TestCase as BaseTestCase;
use RyanChandler\BladeCaptureDirective\BladeCaptureDirectiveServiceProvider;
use Spatie\LaravelMarkdown\MarkdownServiceProvider;
use Spatie\LaravelSettings\LaravelSettingsServiceProvider;
use Spatie\MediaLibrary\MediaLibraryServiceProvider;
use Spatie\Translatable\TranslatableServiceProvider;
use TomatoPHP\FilamentAccounts\FilamentAccountsServiceProvider;
use TomatoPHP\FilamentBlog\FilamentBlogServiceProvider;
use TomatoPHP\FilamentBlog\Tests\Models\User;
use TomatoPHP\FilamentCms\FilamentCmsServiceProvider;
use TomatoPHP\FilamentIcons\FilamentIconsServiceProvider;
use TomatoPHP\FilamentMenus\FilamentMenusServiceProvider;
use TomatoPHP\FilamentSeo\FilamentSeoServiceProvider;
use TomatoPHP\FilamentSettingsHub\FilamentSettingsHubServiceProvider;
use TomatoPHP\FilamentTranslationComponent\FilamentTranslationComponentServiceProvider;
use TomatoPHP\FilamentTypes\FilamentTypesServiceProvider;

#[WithEnv('DB_CONNECTION', 'testing')]
abstract class TestCase extends BaseTestCase
{
    use LazilyRefreshDatabase;

    protected function getPackageProviders($app): array
    {
        $providers = [
            ActionsServiceProvider::class,
            BladeBoxiconsServiceProvider::class,
            BladeCaptureDirectiveServiceProvider::class,
            BladeHeroiconsServiceProvider::class,
            BladeIconsServiceProvider::class,
            FilamentServiceProvider::class,
            FormsServiceProvider::class,
            InfolistsServiceProvider::class,
            LivewireServiceProvider::class,
            NotificationsServiceProvider::class,
            QueryBuilderServiceProvider::class,
            SchemasServiceProvider::class,
            SupportServiceProvider::class,
            TablesServiceProvider::class,
            WidgetsServiceProvider::class,
            PowerJoinsServiceProvider::class,
            ImpersonateServiceProvider::class,
            SpatieTranslatableServiceProvider::class,
            MarkdownServiceProvider::class,
            MediaLibraryServiceProvider::class,
            LaravelSettingsServiceProvider::class,
            SpatieLaravelSettingsPluginServiceProvider::class,
            TranslatableServiceProvider::class,
            FilamentAccountsServiceProvider::class,
            FilamentCmsServiceProvider::class,
            FilamentIconsServiceProvider::class,
            FilamentMenusServiceProvider::class,
            FilamentSeoServiceProvider::class,
            FilamentSettingsHubServiceProvider::class,
            FilamentTranslationComponentServiceProvider::class,
            FilamentTypesServiceProvider::class,
            FilamentBlogServiceProvider::class,
            AdminPanelProvider::class,
            UserPanelProvider::class,
        ];

        sort($providers);

        return $providers;
    }

    public function getEnvironmentSetUp($app): void
    {
        $app['config']->set('database.default', 'testing');
        $app['config']->set('auth.providers.users.model', User::class);
        $app['config']->set('app.locale', 'en');
    }
}
