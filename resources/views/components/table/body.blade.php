@props(['columns', 'records', 'rowUrl' => null, 'rowMethodUrl' => null])

@push('styles')
	<style>
		[data-color-scheme="light"] {
			.table-row:hover {
				background-color: var(--color-surface-500);
			}
		}
	</style>
@endpush

<tbody>
	@foreach ($records as $record)
		<tr class="hover:bg-surface-400 border-border table-row border-t transition-colors">

			@foreach ($columns as $column)
				<x-table.cell
					:column="$column"
					:record="$record"
				/>
			@endforeach

		</tr>
	@endforeach

</tbody>
