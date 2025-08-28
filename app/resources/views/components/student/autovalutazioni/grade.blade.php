<div class="grade">
	<h2 class="text-center text-4xl font-semibold italic">{{ $grade->name }}</h2>

	<div class="areas columns-25rem mt-8 grid items-start gap-4">
		@foreach ($areas as $area)
			<x-student.autovalutazioni.area
				:$area
				:$grade
				:$student
			/>
		@endforeach
	</div>
</div>
