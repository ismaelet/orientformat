@push('styles')
    <style>
        .header-container {
            grid-area: header;
        }

        .main-header {
            position: relative;
            top: 0;
            left: 0;
            right: 0;
            z-index: 100;
            padding-inline: var(--content-padding);
            /* background: var(--clr-background); */
            transition: background 0.2s;
        }

        .main-header[data-local-theme='dark']:not([data-navigation-status="open"]) {
            color: #fff;
        }

        .main-header[data-floating='true'] {
            position: absolute;
        }

        .main-header[data-local-theme='dark']:not([data-navigation-status="open"]) {
            background: linear-gradient(180deg, rgba(0, 0, 0, 0.30) 0%, rgba(0, 0, 0, 0.00) 100%);
        }

        .desktop-header {
            @media (max-width: 1024px) {
                display: none !important;
            }
        }

        .mobile-header {
            @media (min-width: 1025px) {
                display: none !important;
            }
        }
    </style>
@endpush

<div class="header-container">
    <header class="main-header" data-local-theme="{{ $config['theme'] ?? 'light' }}"
        data-floating="{{ !empty($config['floating']) ? 'true' : 'false' }}"
        data-sticky="{{ !empty($config['sticky']) ? 'true' : 'false' }}" x-data="{ open: false }"
        :class="open ? 'bg-background' : ''" :data-navigation-status="open ? 'open' : 'closed'"
        @toggle_mobile_navigation.window="open = ! open">
        <x-navigation.header.desktop-header class="desktop-header" />
        <x-navigation.header.mobile-header class="mobile-header" />
    </header>
</div>
