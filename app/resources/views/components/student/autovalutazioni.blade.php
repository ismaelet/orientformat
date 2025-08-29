<div class="">
	<div class="grid grid-cols-1 justify-items-center gap-12">
		@if ($userType === 'student')
			<x-heading.main class="text-center">Le tue autovalutazioni</x-heading.main>
		@else
			<div class="grid grid-cols-1 justify-items-center">
				<p class="text-xl">
					Autovalutazioni
				</p>

				<p>di</p>

				<x-heading.main><?= $student->fullName ?></x-heading.main>
			</div>
		@endif

		<x-button
			href="{{ $returnUrl }}"
			variant="secondary"
		>Indietro</x-button>

		<p class="text-center text-lg">{!! $description !!}</p>
	</div>

	<div class="grades mt-12 grid grid-cols-1 gap-12">
		@foreach ($grades as $grade)
			<x-student.autovalutazioni.grade
				:$student
				:$grade
			/>
		@endforeach
	</div>
</div>
