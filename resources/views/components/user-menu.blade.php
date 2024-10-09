
@php
    $user = auth('accounts')->user();
    $items = filament()->getUserMenuItems();

    $profileItem = $items['profile'] ?? $items['account'] ?? null;
    $profileItemUrl = url(config('filament-blog.user-panel'));
    $profilePage = filament()->getProfilePage();
    $hasProfileItem = filament()->hasProfile() || filled($profileItemUrl);

    $logoutItem = $items['logout'] ?? null;

    $items = \Illuminate\Support\Arr::except($items, ['account', 'logout', 'profile']);
@endphp

<x-filament::dropdown
    placement="bottom-end"
    teleport
>
    <x-slot name="trigger">
        <button
            aria-label="{{ __('filament-panels::layout.actions.open_user_menu.label') }}"
            type="button"

        >
            <x-icon name="heroicon-s-user" class="w-5 h-5" />
        </button>
    </x-slot>

    @if ($profileItem?->isVisible() ?? true)
        {{ \Filament\Support\Facades\FilamentView::renderHook(\Filament\View\PanelsRenderHook::USER_MENU_PROFILE_BEFORE) }}

        @if ($hasProfileItem)
            <x-filament::dropdown.list>
                <x-filament::dropdown.list.item
                    :color="$profileItem?->getColor()"
                    :icon="$profileItem?->getIcon() ?? \Filament\Support\Facades\FilamentIcon::resolve('panels::user-menu.profile-item') ?? 'heroicon-m-user-circle'"
                    :href="$profileItemUrl ?? filament()->getProfileUrl()"
                    :target="($profileItem?->shouldOpenUrlInNewTab() ?? false) ? '_blank' : null"
                    tag="a"
                >
                    {{ $profileItem?->getLabel() ?? ($profilePage ? $profilePage::getLabel() : null) ?? filament()->getUserName(auth('accounts')->user()) }}
                </x-filament::dropdown.list.item>
            </x-filament::dropdown.list>
        @else
            <x-filament::dropdown.header
                :color="$profileItem?->getColor()"
                :icon="$profileItem?->getIcon() ?? \Filament\Support\Facades\FilamentIcon::resolve('panels::user-menu.profile-item') ?? 'heroicon-m-user-circle'"
            >
                {{ $profileItem?->getLabel() ?? filament()->getUserName(auth('accounts')->user()) }}
            </x-filament::dropdown.header>
        @endif

        {{ \Filament\Support\Facades\FilamentView::renderHook(\Filament\View\PanelsRenderHook::USER_MENU_PROFILE_AFTER) }}
    @endif


    <x-filament::dropdown.list>
        @foreach ($items as $key => $item)
            @php
                $itemPostAction = $item->getPostAction();
            @endphp

            <x-filament::dropdown.list.item
                :action="$itemPostAction"
                :color="$item->getColor()"
                :href="$item->getUrl()"
                :icon="$item->getIcon()"
                :method="filled($itemPostAction) ? 'post' : null"
                :tag="filled($itemPostAction) ? 'form' : 'a'"
                :target="$item->shouldOpenUrlInNewTab() ? '_blank' : null"
            >
                {{ $item->getLabel() }}
            </x-filament::dropdown.list.item>
        @endforeach

        <x-filament::dropdown.list.item
            :action="url(config('filament-blog.user-panel').'/logout')"
            :color="$logoutItem?->getColor()"
            :icon="$logoutItem?->getIcon() ?? \Filament\Support\Facades\FilamentIcon::resolve('panels::user-menu.logout-button') ?? 'heroicon-m-arrow-left-on-rectangle'"
            method="post"
            tag="form"
        >
            {{ $logoutItem?->getLabel() ?? __('filament-panels::layout.actions.logout.label') }}
        </x-filament::dropdown.list.item>
    </x-filament::dropdown.list>
</x-filament::dropdown>
