@php
    if(!$away && !str($url)->contains(url('/'))){
        $url = url(app()->getLocale() . '/' . $url);
    }
@endphp

<a href="{{ $url }}" @if($away) target="_blank" @endif  class="flex justify-start gap-2  text-white bg-gray-900 hover:bg-gray-700 dark:bg-gray-700 dark:hover:bg-gray-600 px-8 py-3 w-full rounded-3xl" >
    <div class="flex flex-col justify-center items-center">
        @if($icon)
            <x-icon name="{{ $icon }}" class="w-5 h-5 rtl:ml-1 rtl:-mr-1.5 mr-1 -ml-1.5"/>
        @endif
    </div>
    <div class="flex flex-col justify-center items-center">
        {{ $label }}
    </div>
</a>
