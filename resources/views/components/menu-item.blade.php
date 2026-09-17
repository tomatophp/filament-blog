@php
    $href = str($url)->startsWith(['http://', 'https://', '//', '#', 'mailto:', 'tel:'])
        ? $url
        : \TomatoPHP\FilamentBlog\FilamentBlog::url((string) $url);
@endphp
<li>
    @if(url()->current() === $href)
        <a href="{{ $href }}" @if($target) target="{{ $target }}" @endif class="underline underline-offset-[7px] decoration-[3px] decoration-main font-medium hover:text-gray-900 dark:hover:text-white px-4 py-3 flex items-center transition duration-150 ease-in-out">
            {{ $label }}
        </a>
    @else
        <a href="{{ $href }}" @if($target) target="{{ $target }}" @endif class="font-medium hover:text-gray-900 dark:hover:text-white px-4 py-3 flex items-center transition duration-150 ease-in-out">
            {{ $label }}
        </a>
    @endif
</li>
