@push('styles')
    <style>
        .main-footer__body {
            grid-template-columns: minmax(200px, .3fr) 1fr;
            max-width: calc(1500px + var(--content-padding) * 2);
            padding-inline: var(--content-padding);
            padding-block: min(6rem, 10vw) min(5rem, 10vw);
        }
    </style>
@endpush

<footer class="main-footer grid justify-items-center bg-primary-100 border-t-[5px] border-primary-200">
    <div class="main-footer__body w-full lg:grid gap-12">
        <x-navigation.footer.aside />

        <div class="main-footer__columns flex flex-wrap justify-between gap-8 py-4">
            @foreach (config('custom.footer_navigation_links') as $title => $data)
                <x-navigation.footer.column :$title :$data />
            @endforeach
        </div>
    </div>

    <x-navigation.footer.notes />
</footer>
