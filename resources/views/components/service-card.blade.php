<a href="{{ url(app()->getLocale() .'/'. $url) }}" class="group mx-4 relative block h-64 sm:h-80 lg:h-96">
    <span class="absolute inset-0 border-2 rounded-lg border-dashed border-black dark:border-slate-800"></span>

    <div
        class="relative flex h-full transform rounded-lg items-end border-2 border-black dark:border-slate-800 bg-white dark:bg-black/20 transition-transform group-hover:-translate-x-2 group-hover:-translate-y-2"
    >
        <div
            class="p-4 !pt-0 transition-opacity group-hover:absolute group-hover:opacity-0 sm:p-6 lg:p-8"
        >
            <x-icon name="heroicon-o-heart" class="w-12 h-12 text-main" />

            <h2 class="mt-4 text-xl font-medium sm:text-2xl text-black dark:text-white">{!! $label !!}</h2>
        </div>

        <div
            class="absolute p-4 opacity-0 transition-opacity group-hover:relative group-hover:opacity-100 sm:p-6 lg:p-8"
        >
            <h3 class="mt-4 text-xl font-medium sm:text-2xl text-black dark:text-white">{!! $label !!}</h3>

            <p class="mt-4 text-sm sm:text-base text-gray-400">
                {!! $description !!}
            </p>

            <p class="mt-8 font-bold text-black dark:text-white">{{ trans('filament-blog::messages.services.more') }}</p>
        </div>
    </div>
</a>
