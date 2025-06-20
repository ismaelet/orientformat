@props(['theme' => null, 'colorScheme' => null])

@pushOnce('styles')
	<style>
		main {
			display: grid;
			min-height: 100svh;
		}

		@supports not (min-height: 100svh) {
			main {
				min-height: 100vh;
			}
		}
	</style>
@endPushOnce

<x-layouts.app
	:theme="$theme"
	:colorScheme="$colorScheme"
>

	<main>{{ $slot }}</main>

</x-layouts.app>
