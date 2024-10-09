<div>
    <div class="group mx-4 border-gray-200 relative border bg-white dark:bg-gray-900 dark:border-slate-800 rounded-xl overflow-hidden">
        <div class="aspect-h-3 aspect-w-4 overflow-hidden bg-gray-100">
            <img alt="{{ $post->title }}" src="{{ $post->getFirstMediaUrl('feature_image') }}" class="object-cover object-center">
        </div>
        <div class="p-4">
            <a href="{{ url(app()->getLocale() .'/portfolios/'. $post->slug) }}" class="flex items-center justify-between gap-4 text-base font-medium">
                <h3>
                <span  title="{{ $post->title }}" aria-label="{{ $post->title }}" class="font-bold font-display text-xl text-black dark:text-gray-200">
                    <span aria-hidden="true" class="absolute inset-0"></span>
                    {!! $post->title !!}
                </span>
                </h3>
            </a>
            <p class="mt-1 text-sm text-gray-700 dark:text-gray-200/90">
                {!! $post->short_description !!}
            </p>
        </div>
    </div>
    @if(count($post->categories))
        <div class="flex flex-wrap gap-2 mt-4 mx-4">
            @foreach($post->categories as $category)
                <a href="{{ url()->current() . (str(url()->current())->contains('?') ? '&' : '?').'service=' . $category->slug }}" class="inline-flex items-center justify-center space-x-1 text-primary-700 bg-primary-500/10 min-h-6 px-2 py-0.5 text-sm font-medium tracking-tight rounded-xl whitespace-normal">
                    {{ $category->name }}
                </a>
            @endforeach
        </div>
    @endif
</div>
