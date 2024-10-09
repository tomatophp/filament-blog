<header class="sticky top-0 z-40 flex-none mx-auto w-full bg-white md:bg-white/90 dark:bg-slate-950 dark:md:bg-slate-950/90 md:backdrop-blur-sm border-b dark:border-b-0">
    <div class="py-3 px-3 mx-auto w-full md:flex md:justify-between max-w-6xl md:px-4">
        <div class="flex justify-between">
            <a class="flex items-center" href="{{ url(app()->getLocale()) }}">
                <span class="self-center ml-2 text-2xl font-extrabold text-gray-900 whitespace-nowrap dark:text-white">
                    {{ trans('filament-blog::messages.emoji') }}
                </span>
            </a>

                <div class="flex items-center md:hidden">
                    <div class="items-center md:flex">
                        <button aria-label="Switch Theme" id="theme-mode-min" class="text-gray-500 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-700 focus:outline-none focus:ring-4 focus:ring-gray-200 dark:focus:ring-gray-700 rounded-lg text-sm p-2.5 inline-flex items-center">
                            <x-icon name="heroicon-s-moon" class="w-5 h-5 hidden" id="dark-mode-moon-min" />
                            <x-icon name="heroicon-s-sun" class="w-5 h-5" id="dark-mode-sun-min" />
                        </button>
                        @if(str(url()->current())->contains(url('/en')) || str(url()->current())->contains(url('/ar')))
                            <a href="{{ app()->getLocale() === 'en' ? str(url()->current())->replaceFirst('/en', '/ar') : str(url()->current())->replaceFirst('/ar', '/en') }}" aria-label="Switch Language" class="text-gray-500 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-700 focus:outline-none focus:ring-4 focus:ring-gray-200 dark:focus:ring-gray-700 rounded-lg text-sm p-2.5 inline-flex items-center">
                                <x-icon name="heroicon-s-language" class="w-5 h-5" />
                            </a>
                        @endif

                        <a href="{{ url(app()->getLocale() . '/contact') }}" aria-label="Contact" class="text-gray-500 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-700 focus:outline-none focus:ring-4 focus:ring-gray-200 dark:focus:ring-gray-700 rounded-lg text-sm p-2.5 inline-flex items-center">
                            <x-icon name="bxs-envelope" class="w-5 h-5" />
                        </a>
                        @if(auth('accounts')->user())
                            <div class="text-gray-500 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-800 focus:outline-none focus:ring-4 focus:ring-gray-200 dark:focus:ring-gray-700 rounded-lg text-sm p-2.5 inline-flex items-center transition">
                                <x-cms-user-menu />
                            </div>
                        @endif
                        <button type="button" class="ml-1.5 text-gray-500 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-800 focus:outline-none focus:ring-4 focus:ring-gray-200 dark:focus:ring-gray-700 rounded-lg text-sm p-2.5 inline-flex items-center transition" aria-label="Toggle Menu" data-toggle-menu="">
                            <x-icon name="heroicon-s-bars-2" class="w-5 h-5" />
                        </button>
                    </div>
                </div>
        </div>
        <nav class="items-center w-full md:w-auto hidden md:flex text-gray-600 dark:text-slate-200 h-screen md:h-auto" aria-label="Main navigation" id="menu">
            <ul class="flex flex-col pt-8 md:pt-0 md:flex-row md:self-center w-full md:w-auto collapsed text-xl md:text-base">
                @include('filament-blog::parts.menu')
            </ul>

                <div class="md:self-center flex items-center mb-4 md:mb-0 ml-2">
                    <div class="hidden items-center md:flex">
                        <button aria-label="Switch Theme" id="theme-mode" class="text-gray-500 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-700 focus:outline-none focus:ring-4 focus:ring-gray-200 dark:focus:ring-gray-700 rounded-lg text-sm p-2.5 inline-flex items-center">
                            <x-icon name="heroicon-s-moon" class="w-5 h-5 hidden" id="dark-mode-moon" />
                            <x-icon name="heroicon-s-sun" class="w-5 h-5" id="dark-mode-sun" />
                        </button>
                        @if(str(url()->current())->contains(url('/en')) || str(url()->current())->contains(url('/ar')))
                            <a href="{{ app()->getLocale() === 'en' ? str(url()->current())->replaceFirst('/en', '/ar') : str(url()->current())->replaceFirst('/ar', '/en') }}" aria-label="Switch Language" class="text-gray-500 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-700 focus:outline-none focus:ring-4 focus:ring-gray-200 dark:focus:ring-gray-700 rounded-lg text-sm p-2.5 inline-flex items-center">
                                <x-icon name="heroicon-s-language" class="w-5 h-5" />
                            </a>
                        @endif
                        <a href="{{ url(app()->getLocale() . '/contact') }}"  aria-label="Contact" class="text-gray-500 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-700 focus:outline-none focus:ring-4 focus:ring-gray-200 dark:focus:ring-gray-700 rounded-lg text-sm p-2.5 inline-flex items-center">
                            <x-icon name="bxs-envelope" class="w-5 h-5" />
                        </a>
                        @if(auth('accounts')->user())
                            <div class="text-gray-500 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-700 focus:outline-none focus:ring-4 focus:ring-gray-200 dark:focus:ring-gray-700 rounded-lg text-sm p-2.5 inline-flex items-center">
                                <x-cms-user-menu />
                            </div>
                        @endif
                    </div>
                </div>
        </nav>
    </div>
</header>

<script>
    document.getElementById('theme-mode-min').addEventListener('click', () => {
        if(document.querySelector('html').classList.contains('dark')) {
            swatchTheme('light');
        } else {
            swatchTheme('dark');
        }
    });
    document.getElementById('theme-mode').addEventListener('click', () => {
        if(document.querySelector('html').classList.contains('dark')) {
            swatchTheme('light');
        } else {
            swatchTheme('dark');
        }
    });

    function swatchTheme(mode=null){
        if(mode === 'light') {
            document.querySelector('html').classList.remove('dark');
            document.querySelector('html').classList.add('light');
            document.querySelector('#dark-mode-sun').classList.add('hidden');
            document.querySelector('#dark-mode-moon').classList.remove('hidden');
            document.querySelector('#dark-mode-sun-min').classList.add('hidden');
            document.querySelector('#dark-mode-moon-min').classList.remove('hidden');

            window.localStorage.setItem('theme', 'light');
        } else {
            document.querySelector('html').classList.add('dark');
            document.querySelector('html').classList.remove('light');
            document.querySelector('#dark-mode-moon').classList.add('hidden');
            document.querySelector('#dark-mode-sun').classList.remove('hidden');
            document.querySelector('#dark-mode-moon-min').classList.add('hidden');
            document.querySelector('#dark-mode-sun-min').classList.remove('hidden');

            window.localStorage.setItem('theme', 'dark');
        }
    }

    if(window.localStorage.getItem('theme') === 'dark') {
        swatchTheme('dark');
    }
    else if(window.localStorage.getItem('theme') === 'light'){
        swatchTheme('light');
    }
    else {
        window.matchMedia('(prefers-color-scheme: dark)').addEventListener('change', event => {
            const newColorScheme = event.matches ? "dark" : "light";

            if(newColorScheme === 'dark'){
                swatchTheme('dark');
            }
            else {
                swatchTheme('light');
            }

        });
    }
</script>
