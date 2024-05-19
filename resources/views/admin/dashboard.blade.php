<x-layouts.admin-dashboard>

	<x-dashboard.typography.main-heading title="Dashboard" />

	<div class="mt-8 grid gap-4">
		{{-- Row 1 --}}
		<div class="grid grid-cols-1 gap-4 lg:grid-cols-7">

			<div class="col-span-2 grid gap-4">
				<x-dashboard.widget.new-students />
				<x-dashboard.widget.new-teachers />
				<x-dashboard.widget.new-classes />
			</div>

			<x-dashboard.widget.students-graph />

		</div>

		{{-- Row 2 --}}
		<div class="grid grid-cols-1 gap-4 lg:grid-cols-7">

			<x-dashboard.widget.activities-graph />

		</div>
	</div>
</x-layouts.admin-dashboard>
