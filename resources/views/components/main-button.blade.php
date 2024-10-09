
@if($type === 'button')
    <button {{ $attributes }}  >
       <div class="flex justify-start gap-2 text-white border border-primary-600/30 bg-primary-600/90 dark:bg-primary-800/80 hover:bg-primary-800 hover:border-primary-800 sm:mb-0 px-8 py-3 w-full rounded-3xl">
           <div class="flex flex-col justify-center items-center">
               <div>
                   @if($icon)
                       <x-icon name="{{ $icon }}" class="w-5 h-5 rtl:ml-1 rtl:-mr-1.5 mr-1 -ml-1.5"/>
                   @endif
               </div>
           </div>

           <div class="flex flex-col justify-center items-center">
               {{ $label }}
           </div>
       </div>
    </button>

@else
    @php
        if(!$away && !str($url)->contains(url('/'))){
            $url = url(app()->getLocale() . '/' . $url);
        }
    @endphp
    <a href="{{ $url }}" @if($away) target="_blank" @endif class="flex justify-start gap-2 text-white border border-primary-600/30 bg-primary-600/90 dark:bg-primary-800/80 hover:bg-primary-800 hover:border-primary-800 sm:mb-0 px-8 py-3 w-full rounded-3xl"  >
        <div class="flex flex-col justify-center items-center">
            <div>
                @if($icon)
                    <x-icon name="{{ $icon }}" class="w-5 h-5 rtl:ml-1 rtl:-mr-1.5 mr-1 -ml-1.5"/>
                @endif
            </div>
        </div>

        <div class="flex flex-col justify-center items-center">
            {{ $label }}
        </div>
    </a>

@endif
