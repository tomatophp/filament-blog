@php
    $user = \TomatoPHP\FilamentBlog\FilamentBlog::account();
    $userPanelUrl = url(config('filament-blog.user-panel'));
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

    <x-filament::dropdown.list>
        <x-filament::dropdown.list.item
            icon="heroicon-m-user-circle"
            :href="$userPanelUrl"
            tag="a"
        >
            {{ $user?->name }}
        </x-filament::dropdown.list.item>
    </x-filament::dropdown.list>

    <x-filament::dropdown.list>
        <x-filament::dropdown.list.item
            :action="$userPanelUrl . '/logout'"
            icon="heroicon-m-arrow-left-on-rectangle"
            method="post"
            tag="form"
        >
            {{ __('filament-panels::layout.actions.logout.label') }}
        </x-filament::dropdown.list.item>
    </x-filament::dropdown.list>
</x-filament::dropdown>
