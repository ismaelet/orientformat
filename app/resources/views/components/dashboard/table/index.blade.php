<x-layouts.admin-dashboard>

	<div class="grid gap-8">
		{{-- Title bar --}}
		<x-dashboard.table.title :title="$title" />

		@if (session('status'))
			{{-- Status alert --}}
			<x-alerts.success>{{ session('status') }}</x-alerts.success>
		@endif

		@if (session('error'))
			{{-- Error alert --}}
			<x-alerts.error>{{ session('error') }}</x-alerts.error>
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
