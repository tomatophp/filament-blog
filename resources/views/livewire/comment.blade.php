<div class="flex flex-col gap-4  mx-8 sm:w-1/2 sm:mx-auto">
    @php
        $comments = $this->post->comments()->where('is_active', 1)->orderBy('created_at', 'desc')->paginate(20);
    @endphp
    @if(count($comments))
        <h2 class="text-2xl font-bold">{{ trans('filament-blog::messages.comments.title') }}</h2>
        <div class="flex flex-col justify-start gap-4">
            @foreach($comments as $comment)
                <div  class="flex flex-col bg-white dark:bg-slate-900 rounded-lg border border-gray-200 dark:border-slate-800 shadow-sm">
                    <div class="p-4">
                        <section data-theme="light" class="prose prose-lg lg:prose-xl dark:prose-invert dark:prose-headings:text-slate-300 prose-headings:font-heading prose-headings:leading-tighter prose-headings:tracking-tighter prose-headings:font-bold prose-img:rounded-md prose-img:shadow-lg prose-a:text-black/75 dark:prose-a:text-white/90 prose-a:underline prose-a:underline-offset-4 prose-a:decoration-primary-500 hover:prose-a:decoration-primary-600 prose-a:decoration-2 hover:prose-a:decoration-4 hover:prose-a:text-black dark:hover:prose-a:text-white break-words tracking-normal prose-h4:tracking-normal prose-h5:tracking-normal prose-h6:tracking-normal prose-code:before:hidden prose-code:after:hidden markdown-body">
                            {!! str($comment->comment)->markdown() !!}
                        </section>
                    </div>
                    <div class="flex justify-between border-t border-gray-200 dark:border-slate-800  p-4">
                        <a href="{{ url('@' . $comment->user?->username) }}"  class="flex justify-start gap-4 w-full ">
                            <div class="flex flex-col justify-center items-center">
                                <x-filament-panels::avatar.user :user="$comment->user" class="w-10 h-10" />
                            </div>

                            <div>
                                <div class="text-sm font-medium text-gray-900 dark:text-gray-200">{{ $comment->user?->name }}</div>
                                <div class="text-sm text-gray-400">{{ $comment->created_at->diffForHumans() }}</div>
                            </div>
                        </a>
                        @if(auth('accounts')->user() && auth('accounts')->user()->id === $comment->user_id)
                            <div class="flex flex-col justify-center items-center">
                                <div class="flex justify-end gap-4">
                                    <div>
                                        {{ ($this->editAction)(['comment' => $comment]) }}
                                    </div>
                                    <div>
                                        {{ ($this->deleteAction)(['comment' => $comment]) }}
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            @endforeach

            {!! $comments->links() !!}
        </div>
    @endif



    @if(auth('accounts')->user())
        <div>
            {{ $this->form }}
        </div>

        <div>
            {{ $this->sendAction }}
        </div>
    @else
        <h1 class="text-center"><x-filament::link class="text-3xl" href="{{ url('user') }}">{{ trans('filament-blog::messages.comments.login') }}</x-filament::link> {{ trans('filament-blog::messages.comments.leave') }}</h1>
    @endif

    <x-filament-actions::modals />
</div>
