@livewireScripts
@livewire('notifications')
@filamentScripts

<script src="{{ asset('/js/jquery-3.7.1.min.js') }}"></script>
<script>
    $(function(){  // $(document).ready shorthand
        $('.app').fadeIn('slow');
    });
</script>

<script type="module">
    function attachEvent(selector, event, fn) {
        const matches = document.querySelectorAll(selector);
        if (matches?.length > 0) {
            for (const element of matches) {
                element.addEventListener(event, () => {
                    fn(element);
                }, false);
            }
        }
    }
    window.onload = () => {
        attachEvent('[data-toggle-menu]', 'click', element => {
            element.classList.toggle('expanded');
            document.body.classList.toggle('overflow-hidden');
            document.getElementById('menu')?.classList.toggle('hidden');
        });

    };
    window.onpageshow = () => {
        const element = document.querySelector('[data-toggle-menu]');
        if (element) {
            element.classList.remove('expanded');
        }
        document.body.classList.remove('overflow-hidden');
        document.getElementById('menu')?.classList.add('hidden');
    };

</script>


@vite('resources/js/app.js')
@stack('js')

@filamentSEO
