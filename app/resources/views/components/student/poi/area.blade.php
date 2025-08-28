<div class="grid grid-cols-1 gap-4 rounded bg-neutral-50 p-8 shadow">
	<div class="">
		<h2 class="panel-title">{{ $name }}</h2>
		<p class="text-lg">{{ $subtitle }}</p>
	</div>
	<p>{{ $description }}</p>

	<div class="results mar-t-2">
		@foreach ($sections as $section)
			<x-student.poi.result
				:$section
				:$student
			/>
		@endforeach
	</div>
</div>
