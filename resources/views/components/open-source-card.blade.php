<div class="flex flex-col justify-start py-4 text-black dark:text-gray-200">
    <div>
        <a href="{{ url( app()->getLocale() .'/open-source/'. $post->slug ) }}" class="text-main underline font-bold text-lg">
            {{ $post->title }}
        </a>
    </div>
    <div class="flex justify-start">
        <div class="flex flex-col justify-start">
            <div>
                <p class="text-md">
                    {!! $post->short_description !!}
                </p>
            </div>
        </div>
    </div>
    <div class="flex justify-start gap-2">
        <div class="font-bold">{{ $post->meta('github_language') }}</div>
        <div class="font-bold text-2xl" style="line-height: 0.5;">.</div>
        <div class="font-sm flex justify-start gap-2">
            <div class="flex flex-col justify-center items-center">
                <x-icon name="bx-git-repo-forked" class="w-4 h-4 text-success-500"/>
            </div>
            <div>
                {{ number_format($post->meta('github_forks')) ?? 0 }}
            </div>
        </div>
        <div class="font-bold text-2xl" style="line-height: 0.5;">.</div>
        <div class="font-sm flex justify-start gap-2">
            <div class="flex flex-col justify-center items-center">
                <x-icon name="bxs-star" class="w-4 h-4 text-warning-500"/>
            </div>
            <div>
                {{ number_format($post->meta('github_starts'))??0 }}
            </div>
        </div>
        @if($post->meta('downloads_total'))
            <div class="font-bold text-2xl" style="line-height: 0.5;">.</div>
            <div class="font-sm flex justify-start gap-2">
                <div class="flex flex-col justify-center items-center">
                    <x-icon name="bxs-download" class="w-4 h-4 text-success-500"/>
                </div>
                <div>
                    {{ number_format($post->meta('downloads_total'))??0 }}
                </div>
            </div>
        @endif

    </div>
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
