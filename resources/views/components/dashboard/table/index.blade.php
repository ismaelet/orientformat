<x-layouts.admin-dashboard>

	<div class="grid gap-8">
		{{-- Title bar --}}
		<x-dashboard.table.title :title="$title" />

		@if (session('status'))
			{{-- Status alert --}}
			<x-inputs.alert-success>{{ session('status') }}</x-inputs.alert-success>
		@endif

		@if (session('error'))
			{{-- Error alert --}}
			<x-inputs.alert-error>{{ session('error') }}</x-inputs.alert-error>
		@endif

		{{-- Table --}}
		<x-table
			:columns="$columns"
			:records="$records"
			:recordCount="$recordCount"
			:mainOrderBy="$mainOrderBy"
			:buttons="$buttons"
		/>
	</div>

</x-layouts.admin-dashboard>
