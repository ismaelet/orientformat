@props(['title', 'body', 'footer', 'method' => 'GET', 'action' => '', 'size' => 'default'])

@push('styles')
	<style>
		main {
			--content-width: 60ch;

			&:has([data-size="lg"]) {
				--content-width: 80ch;
			}
		}

		.form-title {
			font-size: 2.5rem;
		}

		.form-body {
			border-block: var(--border);
		}
	</style>
@endpush

<form
	class="form grid content-center gap-8 py-16"
	action="{{ $action }}"
	method="{{ $method == 'GET' ? 'GET' : 'POST' }}"
	enctype="multipart/form-data"
	data-size="{{ $size }}"
>
	@method($method)

	@csrf

	<x-heading.section class="form-title text-center">{{ $title }}</x-heading.section>

	<div class="form-body grid gap-4 py-4">
		{{ $body }}
	</div>

	<div class="form-footer grid gap-4">
		{{ $footer }}
	</div>
</form>
