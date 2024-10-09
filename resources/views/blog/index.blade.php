@extends('filament-blog::layouts.app')

@section('title', (app()->getLocale() === 'en' ? str(setting('site_name'))->explode('|')[0]??setting('site_name') : str(setting('site_name'))->explode('|')[1]??setting('site_name')) . ' | '. trans('filament-blog::messages.blog.label'))
@section('description', trans('filament-blog::messages.blog.title') . ' ' . trans('filament-blog::messages.blog.sub'))

@section('body')
    <div class="bg-slate-50 dark:bg-inherit min-h-screen">
        <section class="container sm:px-6 py-12 sm:py-16 lg:py-20 mx-auto">
            <header>
                <h1 class="text-center text-4xl md:text-6xl font-bold leading-tighter tracking-tighter  font-heading">
                    {{ trans('filament-blog::messages.blog.title') }}
                    <span class="bg-clip-text text-transparent bg-gradient-to-r from-success-500 to-danger-500 pr-[0.025em] mr-[-0.025em]">
                        {{ request()->has('category') ? \TomatoPHP\FilamentCms\Models\Category::query()->where('slug', request()->get('category'))->first()?->name : trans('filament-blog::messages.blog.sub') }}
                    </span>
                </h1>
            </header>
            <div class="flex flex-col justify-center items-center my-4">
                <div class="max-w-md">
                    <x-cms-filter-toolbar />
                </div>
            </div>
            @if(count($posts))
            <div class="px-6 sm:px-6 flex flex-col gap-4 mx-auto max-w-xl">
                <ul>
                    @foreach ($posts as $item)
                        <x-cms-blog-card
                            :post="$item"
                            :tags="$item->categories()->pluck('name')->toArray()"
                            image="{{ $item->getFirstMediaUrl('feature_image') }}"
                            url="blog/{{ $item->slug }}"
                            label="{{ $item->title }}"
                            description="{{ $item->short_description }}"
                            date="{{ $item->created_at }}"
                        />
                    @endforeach
                </ul>
            </div>

        </section>

        <div>
            <div class="flex flex-col justify-center items-center my-4">
                {!! $posts->links() !!}
            </div>
        </div>

        @else
            <x-cms-empty-state :name="trans('filament-blog::messages.blog.label')"/>
        @endif
    </div>
@endsection
