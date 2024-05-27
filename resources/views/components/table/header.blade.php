@props(['columns'])

<thead class="">
	<tr class="">
		@foreach ($columns as $column)
			<x-table.header-cell :column="$column" />
		@endforeach
	</tr>
</thead>
