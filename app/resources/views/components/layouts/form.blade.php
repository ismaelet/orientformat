@props(['title', 'body', 'footer', 'method' => null, 'action' => null])

@push('styles')
	<style>
		main {
			--content-width: 60ch;
		}

		.form-body {
			border-block: var(--border);
		}
	</style>
@endpush

<x-layouts.main :title="$title">
	<x-form
		:title="$title"
		:body="$body"
		:footer="$footer"
		:action="$action"
		:method="$method"
	/>
</x-layouts.main>
