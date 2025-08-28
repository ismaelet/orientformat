<div
	class="area progressive-color-{{ $area->id }} {{ $sections->count() ? '' : 'hidden' }} rounded bg-neutral-50 p-2 shadow"
>
	<h3 class="text-xl font-semibold">{{ $area->name }}</h3>

	<div class="sections mt-2 grid gap-1">
		@foreach ($sections as $key => $section)
			<x-student.autovalutazioni.section
				:$section
				:$student
				:$key
			/>
		@endforeach
	</div>
</div>
