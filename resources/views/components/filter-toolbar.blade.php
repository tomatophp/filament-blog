<form  method="GET" id="filter-form" action="{{ url()->current() }}">
    <fieldset class="flex flex-col gap-4 justify-center items-center my-4">
        <div class="flex flex-col md:flex-row gap-4 md:justify-between w-full">
            <div class="flex items-center gap-4">
                <div>
                    <label class="sr-only" for="search"> {{ trans('filament-blog::messages.filters.search') }} </label>
                    <div class="relative group">
                      <span class="absolute inset-y-0 left-0 flex items-center justify-center w-10 h-10 text-gray-400 transition pointer-events-none group-focus-within:text-primary-600">
                        <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" aria-hidden="true">
                          <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                      </span>
                        <input
                            id="search"
                            value="{{ request()->get('search') }}"
                            placeholder="{{ trans('filament-blog::messages.filters.search-placeholder') }}"
                            name="search"
                            type="search"
                            class="block h-10 ltr:pl-8 placeholder-gray-400 dark:bg-gray-900 dark:border-gray-700 transition duration-75 border-gray-300 rounded-lg shadow-sm focus:border-primary-600 focus:ring-1 focus:ring-inset focus:ring-primary-600">
                    </div>
                </div>
            </div>
            <div>
                <label class="sr-only" for="sort"> {{ trans('filament-blog::messages.filters.sort') }} </label>
                <select id="sort" name="sort" class="dark:bg-gray-900 dark:border-gray-700  dark:text-gray-200 text-gray-900 h-10 rtl:pr-4 rtl:pl-8 pl-4 pr-8 transition duration-75 border-gray-300 rounded-lg shadow-sm focus:border-primary-600 focus:ring-1 focus:ring-inset focus:ring-primary-600">
                    @if(request()->has('sort'))
                        @if(request()->get('sort') === 'popular')
                            <option value="popular" selected>{{ trans('filament-blog::messages.filters.sort-select.popular') }}</option>
                        @else
                            <option value="popular">{{ trans('filament-blog::messages.filters.sort-select.popular') }}</option>
                        @endif

                        @if(request()->get('sort') === 'recent')
                            <option value="recent" selected>{{ trans('filament-blog::messages.filters.sort-select.recent') }}</option>
                        @else
                            <option value="recent">{{ trans('filament-blog::messages.filters.sort-select.recent') }}</option>
                        @endif

                        @if(request()->get('sort') === 'alphabetical')
                            <option value="alphabetical" selected>{{ trans('filament-blog::messages.filters.sort-select.alphabetical') }}</option>
                        @else
                            <option value="alphabetical">{{ trans('filament-blog::messages.filters.sort-select.alphabetical') }}</option>
                        @endif
                    @else
                        <option value="popular" selected>{{ trans('filament-blog::messages.filters.sort-select.popular') }}</option>
                        <option value="recent">{{ trans('filament-blog::messages.filters.sort-select.recent') }}</option>
                        <option value="alphabetical">{{ trans('filament-blog::messages.filters.sort-select.alphabetical') }}</option>
                    @endif

                </select>
            </div>
        </div>
    </fieldset>
</form>

<script>
    const dropdown = document.getElementById("sort");

    dropdown.addEventListener("change", function() {
        document.getElementById("filter-form")?.submit();
    });
</script>


