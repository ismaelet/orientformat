<div class="area">
	<h3 class="area__title subsection-title">{{ $area->name }}</h3>
	<div class="sections">

		@foreach ($sections as $section)
			<x-class-dashboard.student-result.section
				:section="$section"
				:area="$area"
				:student="$student"
			/>
		@endforeach

	</div>
</div>
