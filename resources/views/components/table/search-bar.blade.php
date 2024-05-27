@php
	$searchText = request()->search ?? null;
@endphp

@push('styles')
	<style>
		.search-bar {
			grid-template-columns: 1.25rem 1fr 1.25rem;

			&:has(:focus) .search-icon {
				color: var(--color-primary-500);
			}

			.input {
				background-color: transparent;
				line-height: 3.5rem;
				border: none !important;
				outline: none !important;
				box-shadow: none !important;
			}
		}
	</style>
@endpush

@push('scripts')
	<script defer>
		function table_search() {
			document.querySelector('.js-search-input').closest('form').submit();
		}

		function empty_table_search() {
			document.querySelector('.js-search-input').value = '';

			table_search()
		}
	</script>
@endpush

<search class="search-bar grid items-center gap-2 rounded border px-6">
	<div
		class="search-icon cursor-pointer transition-colors"
		x-data
		@click="table_search"
	>
		{!! embed_icon('search') !!}
	</div>

	<x-inputs.input
		type="text"
		class="input js-search-input"
		name="search"
		placeholder="Cerca nella lista"
		value="{{ $searchText ?? '' }}"
	/>

	@isset($searchText)
		<div
			class="cursor-pointer transition-colors hover:text-neutral-700"
			x-data
			@click="empty_table_search"
		>
			{!! embed_icon('close') !!}
		</div>
	@endisset
</search>
