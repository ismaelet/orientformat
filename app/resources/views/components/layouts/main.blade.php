@props(['title' => null, 'colorScheme' => null, 'theme' => null])

@pushOnce('styles')
	<style>
		.main-content {
			display: grid;
			grid-template-areas:
				'header'
				'main';
			grid-template-columns: minmax(0, 1fr);
			grid-template-rows: max-content 1fr;
			min-height: 100svh;
		}

		.header-container {
			grid-area: header;
		}

		main {
			grid-area: main;
		}
	</style>
@endPushOnce

<x-layouts.app
	:$title
	:$colorScheme
	:$theme
>
	{{-- Page content --}}
	<div class="main-content min-h-svh">
		{{-- Header --}}
		<div
			class="header-container"
			x-data
			x-init="() => {
    window.addEventListener('load', () => {
        $el.style.height = `${$el.querySelector('header').offsetHeight}px`;
    });
}"
		>
			<x-navigation.header />
		</div>

		{{-- Main --}}
		<main>
			<div class="content-grid min-h-full">
				{{ $slot }}
			</div>
		</main>
	</div>

	{{-- Footer --}}
	<x-navigation.footer />
</x-layouts.app>
