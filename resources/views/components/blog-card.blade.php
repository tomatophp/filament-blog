<li class="mb-10 md:mb-16">
    <article class="max-w-md mx-auto md:max-w-none">
        <div>
            <header>
                <h2 class="text-3xl sm:text-4xl font-bold leading-snug mb-2 font-heading">
                    <a class="hover:underline hover:underline-offset-4 hover:decoration-3" href="{{ url(app()->getLocale() .'/blog/'. $post->slug) }}">
                        {!! $post->title !!}
                    </a>
                </h2>
            </header>
            @if($post->short_description)
                <p class="text-lg sm:text-xl flex-grow mt-2 opacity-80">
                    {!! $post->short_description !!}
                </p>
            @endif
            <footer class="mt-4">
                <div>
              <span class="text-gray-500 dark:text-slate-400">
                <time datetime="{{ $post->created_at }}">{{ \Illuminate\Support\Carbon::parse($post->created_at)->diffForHumans() }}</time></span>
                </div>
            </footer>

            @if(count($post->categories))
                <div class="flex flex-wrap gap-2 my-4">
                    @foreach($post->categories as $category)
                        <a href="{{ url()->current() . (str(url()->current())->contains('?') ? '&' : '?').'category=' . $category->slug }}" class="inline-flex items-center justify-center space-x-1 text-primary-700 bg-primary-500/10 min-h-6 px-2 py-0.5 text-sm font-medium tracking-tight rounded-xl whitespace-normal">
                            {{ $category->name }}
                        </a>
                    @endforeach
                </div>
            @endif
        </div>
    </article>
    <style>
        /* Workaround to not add hover underline to the external link symbol */
        article h2 a:hover {
            box-shadow: inset 0 -4px 0 0 currentColor;
            text-decoration: none !important;
        }
    </style>
</li>
