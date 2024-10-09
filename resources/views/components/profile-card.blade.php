<div class="bg-white dark:bg-slate-800 rounded-lg overflow-hidden shadow-md border border-slate-200 dark:border-slate-700 p-4 min-w-64">
    <div class="flex flex-col items-center justify-center">
        <div class="my-4">
            <x-filament-panels::avatar.user :user="$account" size="24" class="rounded-full w-24 h-24 bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700"/>
        </div>
        <a href="{{ url('@'. $account->username) }}" class="flex justify-center gap-2 font-bold w-full">
            <h1 class="text-xl truncate">{{ $account->name }}</h1>
            <div class="flex flex-col justify-center items-center">
                @if($account->type === 'verified')
                    <x-filament::icon-button icon="bxs-badge-check" tooltip="Verified User" color="info">
                        <x-icon name="bxs-badge-check" class="text-blue-400 text-xl w-5 h-5" />
                    </x-filament::icon-button>
                @elseif($account->type === 'public')
                    <x-filament::icon-button icon="bxs-badge-check" tooltip="Public User">
                        <x-icon name="bxs-badge-check" class="text-blue-400 text-xl w-5 h-5" />
                    </x-filament::icon-button>
                @endif
            </div>
        </a>
        <h6 class="text-sm font-medium text-slate-400 dark:text-slate-300">{{ '@'.$account->username}}</h6>
        @if($account->bio)
            <p class="text-xs text-center my-2 w-full truncate">
                {{$account->bio}}
            </p>
        @endif
        <h6 class="my-2 text-sm text-slate-400 dark:text-slate-300">
            {{__('Joined')}} {{ $account->created_at->diffForHumans() }}
        </h6>
    </div>
</div>
