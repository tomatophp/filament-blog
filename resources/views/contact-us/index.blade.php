@extends('filament-blog::layouts.app')

@section('title', (app()->getLocale() === 'en' ? str(setting('site_name'))->explode('|')[0]??setting('site_name') : str(setting('site_name'))->explode('|')[1]??setting('site_name')) . ' | '. trans('filament-blog::messages.contact.label'))
@section('description', trans('filament-blog::messages.contact.support'))

@section('body')
    <section class="md:min-h-screen sm:px-6 mb-20 mx-auto max-w-3xl md:py-8">
        <main class="container markdown-body mx-auto px-6 sm:px-6 max-w-3xl prose prose-lg lg:prose-xl dark:prose-invert dark:prose-headings:text-slate-300 prose-headings:font-heading prose-headings:leading-tighter prose-headings:tracking-tighter prose-headings:font-bold prose-img:rounded-md prose-img:shadow-lg mt-8 prose-a:text-black/75 dark:prose-a:text-white/90 prose-a:underline prose-a:underline-offset-4 prose-a:decoration-primary-500 hover:prose-a:decoration-primary-600 prose-a:decoration-2 hover:prose-a:decoration-4 hover:prose-a:text-black dark:hover:prose-a:text-white break-words tracking-normal prose-h4:tracking-normal prose-h5:tracking-normal prose-h6:tracking-normal prose-code:before:hidden prose-code:after:hidden">
            <h1 id="contact">{{ trans('filament-blog::messages.contact.title') }}</h1>
            <div class="sm:-mt-2 not-prose text-3xl font-bold bg-clip-text bg-gradient-to-r from-main to-secondary sm:whitespace-nowrap hover:underline hover:underline-offset-8 hover:decoration-4 decoration-black dark:decoration-white">
                <a id="contact-email" href="{{ setting('site_email') }}">
                    {{ setting('site_email') }}
                </a>
            </div>
            <p>{{ trans('filament-blog::messages.contact.time') }} <a href="https://www.google.com/search?q=succinct+emails">{{ trans('filament-blog::messages.contact.succinct') }}</a>. </p>
            <p>{{ trans('filament-blog::messages.contact.support') }}</p>
        </main>
    </section>
@endsection
