<div>
	<h2 class="dashboard-panel__title--outer">{{ $title }}</h2>

	<div class="dashboard-panel grade">
		<div class="areas">

			@foreach ($areas as $area)
				<x-class-dashboard.student-result.area
					:area="$area"
					:student="$student"
					:sections="$sections"
				/>
			@endforeach

		</div>
	</div>
</div>
