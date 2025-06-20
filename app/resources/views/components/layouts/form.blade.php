@props(['title', 'body', 'footer', 'method' => null, 'action' => null])

@pushOnce('styles')
	<style>
		main {
			--content-width: 60ch;
		}

		.form-body {
			border-block: var(--border);
		}
	</style>
@endPushOnce

<x-layouts.main :$title>
	<x-form
		:$title
		:$body
		:$footer
		:$action
		:$method
	/>
</x-layouts.main>
