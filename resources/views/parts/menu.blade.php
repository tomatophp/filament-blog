@php
    $menu = \TomatoPHP\FilamentMenus\Models\Menu::query()
        ->where('key', 'header')
        ->first()
        ?->menuItems()
        ->orderBy('order')
        ->get();
@endphp

@if($menu)
    @foreach($menu as $item)
        <x-cms-menu-item label="{{ $item->localized('title') }}" url="{{ $item->url }}" target="{{ $item->new_tab ? '_blank' : null }}" />
    @endforeach
@endif
