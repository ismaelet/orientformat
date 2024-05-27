@props([
    'searchBar' => true,
    'mainOrderBy',
    'columns',
    'records',
    'recordCount',
    'buttons',
])

@php
	$displayPagination = $recordCount > $records->count();
@endphp

@push('styles')
	<style>
		.table-container {
			grid-template-areas: @if ($searchBar)
				"search-bar"
			@endif
			@if ($displayPagination)
				"top-pagination"
			@endif
			"table"

			@if ($displayPagination)
				"bottom-pagination"
			@endif
			;

			>form {
				display: contents;
			}
		}

		.search-bar {
			grid-area: search-bar;
		}

		.pagination {
			grid-area: top-pagination;
		}

		.pagination:last-child {
			grid-area: bottom-pagination;
		}

		.table {
			grid-area: table;
		}
	</style>
@endpush

<div class="table-container grid gap-8">

	<form
		action=""
		method="GET"
	>
		<input
			type="hidden"
			name="order_by"
			value="{{ request()->order_by }}"
		>
		<input
			type="hidden"
			name="order_direction"
			value="{{ request()->order_direction }}"
		>

		@if ($searchBar)
			{{-- Search bar --}}
			<x-table.search-bar />
		@endif

		@if ($displayPagination)
			{{-- Top pagination --}}
			<x-pagination :recordCount="$recordCount" />

			{{-- Bottom pagination --}}
			<x-pagination :recordCount="$recordCount" />
		@endif
	</form>

	{{-- Table --}}
	<section class="table rounded border p-8">
		<table class="w-full">
			{{--  Table head  --}}
			<x-table.header :columns="$columns" />

			{{-- Table body --}}
			<x-table.body
				:records="$records"
				:columns="$columns"
			/>
		</table>
	</section>
</div>
