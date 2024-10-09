@extends('filament-blog::layouts.app')

@section('title', (app()->getLocale() === 'en' ? str(setting('site_name'))->explode('|')[0]??setting('site_name') : str(setting('site_name'))->explode('|')[1]??setting('site_name')) . ' | '. trans('filament-blog::messages.open-source.label'))
@section('description', trans('filament-blog::messages.open-source.title') . ' ' . trans('filament-blog::messages.open-source.sub'))

@section('body')
    <div class="bg-slate-50 dark:bg-inherit min-h-screen">
        <section class="container sm:px-6 py-12 sm:py-16 lg:py-20 mx-auto">
            <header>
                <h1 class="text-center text-4xl md:text-6xl font-bold leading-tighter tracking-tighter mb-8 md:mb-16 font-heading">
                    {{ trans('filament-blog::messages.open-source.title') }}
                    <span class="bg-clip-text text-transparent bg-gradient-to-r from-success-500 to-danger-500 pr-[0.025em] mr-[-0.025em]">
                        {{ request()->has('category') ? \TomatoPHP\FilamentCms\Models\Category::query()->where('slug', request()->get('category'))->first()?->name : trans('filament-blog::messages.open-source.sub') }}
                    </span>
                </h1>
            </header>
            <div class="mx-6">
                <x-cms-filter-toolbar />
            </div>
            @if(count($openSources))
            <section data-nosnippet="" class="grid grid-cols-1 mx-6 my-4 dark:text-white divide-y divide-gray-200 dark:divide-gray-900">
                @foreach($openSources as $item)
                    <x-cms-open-source-card
                        :post="$item"
                    />
                @endforeach
            </section>

            <div>
                <div class="flex flex-col justify-center items-center my-4">
                    {!! $openSources->links() !!}
                </div>
            </div>
            @else
                <x-cms-empty-state :name="trans('filament-blog::messages.open-source.label')"/>
            @endif
        </section>
    </div>
@endsection
