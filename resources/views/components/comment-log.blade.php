<div class="w-full bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-lg shadow-sm mt-4 overflow-hidden">
    <div class="flex justify-between w-full border-b border-slate-200 dark:border-slate-700 p-4">
        <div class="w-full flex justify-between gap-2">
            <div class="w-full flex justify-start gap-2">
                <a href="{{ url(app()->getLocale() . '/@' . $log->account->username) }}">
                    <div class="w-8 h-8 rounded-full bg-slate-800 border border-slate-200 dark:border-slate-700">
                        <x-filament-panels::avatar.user :user="$log->account" size="8"/>
                    </div>
                </a>
                <div class="flex flex-col justify-center">
                    <div class="flex justify-start gap-1">
                        <a href="{{ url( '@' . $log->account->username) }}" >
                            <div class="flex justify-start gap-2">
                                <div>
                                    <h1 class="font-bold text-md">{{ $log->account->name }}</h1>
                                </div>
                            </div>
                        </a>
                        <h1 class="text-slate-600 dark:text-slate-400">Has Been Comment on Post </h1>
                        <a href="{{ url(app()->getLocale() . '/' . ($log->model?->type === 'open-source' ? 'open-source' : 'blog') . '/' . $log->model?->slug) }}" target="_blank" >
                            <div class="flex justify-start gap-2">
                                <div>
                                    <h1 class="font-bold text-md">{{ $log->model?->title }}</h1>
                                </div>
                                <div class="flex flex-col justify-center items-center">
                                    <x-icon name="bx-link-external" class="w-4 h-4"/>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
            <div  class="flex flex-col justify-center items-center">
                <div>
                    <x-icon name="heroicon-o-chat-bubble-left-right" class="w-5 h-5 text-info-500"/>
                </div>
            </div>
        </div>
    </div>
    <div class="flex justify-center">
        <div class="flex flex-col justify-center w-full px-4">
            <section data-theme="light" class="prose prose-lg lg:prose-xl dark:prose-invert dark:prose-headings:text-slate-300 prose-headings:font-heading prose-headings:leading-tighter prose-headings:tracking-tighter prose-headings:font-bold prose-img:rounded-md prose-img:shadow-lg prose-a:text-black/75 dark:prose-a:text-white/90 prose-a:underline prose-a:underline-offset-4 prose-a:decoration-primary-500 hover:prose-a:decoration-primary-600 prose-a:decoration-2 hover:prose-a:decoration-4 hover:prose-a:text-black dark:hover:prose-a:text-white break-words tracking-normal prose-h4:tracking-normal prose-h5:tracking-normal prose-h6:tracking-normal prose-code:before:hidden prose-code:after:hidden markdown-body">
                <x-markdown>
                    {!! $log->log !!}
                </x-markdown>
            </section>
        </div>
    </div>
</div>
