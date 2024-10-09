@extends('filament-blog::layouts.app')

@section('title', (app()->getLocale() === 'en' ? str(setting('site_name'))->explode('|')[0]??setting('site_name') : str(setting('site_name'))->explode('|')[1]??setting('site_name')) . ' | '. $docs->title)
@section('description', $docs->short_description)
@section('keywords', $docs->keywords)
@if($docs->getFirstMediaUrl('feature_image'))
    @section('image', $docs->getFirstMediaUrl('feature_image'))
@endif

@section('body')
    <div class="bg-slate-50 dark:bg-inherit min-h-screen">
        <header class="flex flex-col items-center text-center px-4 sm:px-6 mb-4">
            <img src="{{ $docs->getFirstMediaUrl('feature_image') }}" width="224" height="224" class="p-[20px] mb-3">
            <h1 class="text-5xl md:text-6xl font-bold leading-tighter tracking-tighter mb-4 font-heading">
                {!! $docs->title !!}
            </h1>
            <h2 class="text-2xl md:text-3xl tracking-tight mb-8">
                {!! $docs->short_description !!}
            </h2>
            <nav class="flex flex-col sm:flex-row gap-x-4 gap-y-8 mt-2 instapaper_ignore">
                <div class="relative">
                    <x-cms-sub-button icon="bxl-github" :away="true" label="Download" url="{{ $docs->meta_url }}" />
                </div>
                <div class="relative">
                    <x-cms-main-button icon="bxs-download" :away="true" label="{{ number_format($docs->meta('downloads_total'))??0 }}" url="{{ $docs->meta_url }}" />
                </div>
                <div class="relative">
                    <x-cms-main-button icon="bxs-star" :away="true" label="{{ number_format($docs->meta('github_starts'))??0 }}" url="{{ $docs->meta_url }}" />
                </div>
            </nav>
        </header>

        <div class="flex flex-col justify-center items-center py-4">
            <section data-theme="light" class="scroll-smooth focus:scroll-auto container mx-auto py-6 rounded-lg px-6 sm:px-6 max-w-3xl prose prose-lg lg:prose-xl dark:prose-invert dark:prose-headings:text-slate-300 prose-headings:font-heading prose-headings:leading-tighter prose-headings:tracking-tighter prose-headings:font-bold prose-img:rounded-md prose-img:shadow-lg mt-8 prose-a:text-black/75 dark:prose-a:text-white/90 prose-a:underline prose-a:underline-offset-4 prose-a:decoration-primary-500 hover:prose-a:decoration-primary-600 prose-a:decoration-2 hover:prose-a:decoration-4 hover:prose-a:text-black dark:hover:prose-a:text-white break-words tracking-normal prose-h4:tracking-normal prose-h5:tracking-normal prose-h6:tracking-normal prose-code:before:hidden prose-code:after:hidden markdown-body">
                <x-markdown theme="github-dark">
                    {!!  $docs->body !!}
                </x-markdown>
            </section>
        </div>

        <div class="flex flex-col sm:flex-row sm:justify-center gap-2">
            <div class="flex flex-col justify-center sm:justify-end items-center sm:items-end">
                @livewire(\TomatoPHP\FilamentBlog\Livewire\LikePost::class, ['post' => $docs])
            </div>

            <x-cms-social-share />
        </div>

        @livewire(\TomatoPHP\FilamentBlog\Livewire\CommentPost::class, ['post' => $docs])
    </div>
@endsection

@push('js')
    <script src="{{ asset('js/highlight.min.js') }}"></script>
    <script>hljs.highlightAll();</script>
    <script>
        $(function(){  // $(document).ready shorthand
// get the list of all highlight code blocks
            const highlights = document.querySelectorAll("pre code");

            highlights.forEach((pre) => {
                if(pre.classList.length >0){
                    // create the copy button
                    const copy = document.createElement("button");
                    copy.innerHTML = "Copy";

                    copy.classList.add("relative");
                    copy.classList.add("float-right");
                    copy.classList.add("text-xs");
                    copy.classList.add("font-semibold");
                    copy.classList.add("text-white");
                    copy.classList.add("bg-gray-800");
                    copy.classList.add("hover:bg-gray-600");
                    copy.classList.add("rounded-md");
                    copy.classList.add("px-2");
                    copy.classList.add("py-1");
                    copy.classList.add("mt-1");
                    // add the event listener to each click
                    copy.addEventListener("click", handleCopyClick);
                    // append the copy button to each code block
                    pre.prepend(copy);
                    pre.classList.add('hljs');
                }

            });

            const copyToClipboard = (str) => {
                const el = document.createElement("textarea"); // Create a <textarea> element
                el.value = str; // Set its value to the string that you want copied
                el.setAttribute("readonly", ""); // Make it readonly to be tamper-proof
                el.style.position = "absolute";
                el.style.left = "-9999px"; // Move outside the screen to make it invisible
                document.body.appendChild(el); // Append the <textarea> element to the HTML document
                const selected =
                    document.getSelection().rangeCount > 0 // Check if there is any content selected previously
                        ? document.getSelection().getRangeAt(0) // Store selection if found
                        : false; // Mark as false to know no selection existed before
                el.select(); // Select the <textarea> content
                document.execCommand("copy"); // Copy - only works as a result of a user action (e.g. click events)
                document.body.removeChild(el); // Remove the <textarea> element
                if (selected) {
                    // If a selection existed before copying
                    document.getSelection().removeAllRanges(); // Unselect everything on the HTML document
                    document.getSelection().addRange(selected); // Restore the original selection
                }
            };

            function handleCopyClick(evt) {
                // get the children of the parent element
                let innerText = evt.target.parentElement.textContent.replace('Copy', '');

                // copy all of the code to the clipboard
                copyToClipboard(innerText);
                // Change the button's text to "Copied"
                this.textContent = "Copied";
                // Change back the button text to "Copy" after 2 sec
                setTimeout(() => {
                    this.textContent = "Copy";
                }, 2000);
            }
        });
    </script>
@endpush
