<div class="w-full bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-lg shadow-sm mt-4 overflow-hidden">
    <div class="flex justify-between w-full p-4">
        <div class="w-full flex justify-between gap-2">
            <div class="w-full flex justify-start gap-2">
                <a href="{{ url(app()->getLocale() . '/@' . $log->account->username) }}">
                    <div class="w-8 h-8 rounded-full bg-slate-800 border border-slate-200 dark:border-slate-700">
                        <x-filament-panels::avatar.user :user="$log->account" size="8"/>
                    </div>
                </a>
                <div class="flex flex-col justify-center">
                    <div class="flex justify-start gap-1">
                        <a href="{{ url('@' . $log->account->username) }}" >
                            <div class="flex justify-start gap-2">
                                <div>
                                    <h1 class="font-bold text-md">{{ $log->account->name }}</h1>
                                </div>
                            </div>
                        </a>
                        <h1 class="text-slate-600 dark:text-slate-400">Has Been Like Post </h1>
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
            <div class="flex flex-col justify-center items-center">
                <div>
                    <x-icon name="heroicon-o-heart" class="w-5 h-5 text-danger-500"/>
                </div>
            </div>
        </div>
    </div>
</div>
