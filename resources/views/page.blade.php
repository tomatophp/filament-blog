@extends('filament-blog::layouts.app')

@section('title', (app()->getLocale() === 'en' ? str(setting('site_name'))->explode('|')[0]??setting('site_name') : str(setting('site_name'))->explode('|')[1]??setting('site_name')) . ' | '. $page->title)
@section('description', $page->short_description)
@section('keywords', $page->keywords)
@if($page->getFirstMediaUrl('feature_image'))
    @section('image', $page->getFirstMediaUrl('feature_image'))
@endif

@section('body')
    <div class="bg-slate-50 dark:bg-inherit min-h-screen">
        <section class="container sm:px-6 py-12 sm:py-16 lg:py-20 mx-auto">
            <header>
                <h1 class="px-4 sm:px-6 max-w-3xl mx-auto text-center text-5xl md:text-6xl font-bold leading-tighter tracking-tighter mb-8 font-heading">
                    {{ $page->title }}
                </h1>
                <h2 class="px-4 sm:px-6 mt-[-4px] max-w-3xl mx-auto text-center text-xl md:text-2xl opacity-80">
                    {!! $page->short_description !!}
                </h2>
            </header>

            <div class="flex flex-col justify-center items-center py-4">
                <section class="container mx-auto py-6 rounded-lg px-6 sm:px-6 max-w-3xl prose prose-lg lg:prose-xl dark:prose-invert dark:prose-headings:text-slate-300 prose-headings:font-heading prose-headings:leading-tighter prose-headings:tracking-tighter prose-headings:font-bold prose-img:rounded-md prose-img:shadow-lg mt-8 prose-a:text-black/75 dark:prose-a:text-white/90 prose-a:underline prose-a:underline-offset-4 prose-a:decoration-primary-500 hover:prose-a:decoration-primary-600 prose-a:decoration-2 hover:prose-a:decoration-4 hover:prose-a:text-black dark:hover:prose-a:text-white break-words tracking-normal prose-h4:tracking-normal prose-h5:tracking-normal prose-h6:tracking-normal prose-code:before:hidden prose-code:after:hidden markdown-body">
                    <x-markdown theme="github-dark">
                        {!!  $page->body !!}
                    </x-markdown>
                </section>
            </div>

            <x-cms-social-share />
            <div>
                @livewire(\Modules\Cms\Livewire\LikePost::class, ['post' => $docs])
            </div>
        </section>
    </div>
@endsection


@push('css')
    <link rel="stylesheet" href="{{ asset('css/code/github-dark.min.css') }}">
@endpush

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
