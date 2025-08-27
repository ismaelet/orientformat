<x-layouts.class-dashboard :$class>

	<x-heading.main>Progresso della classe</x-heading.main>

	<div class="mb-16 mt-4">
		<livewire:class.progress.toggler />
	</div>

	{{-- Grade --}}
	<div class="grid grid-cols-1 gap-20">
		@foreach ($grades as $grade)
			<div class="">
				<h2 class="mb-4 rounded bg-slate-300 px-4 py-2 text-lg font-semibold shadow">{{ $grade->name }}</h2>

				<div class="columns-25rem grid gap-4">
					{{-- Area --}}
					@foreach ($grade->areas as $area)
						<livewire:class.progress.area
							:area="$area"
							:grade="$grade"
							:class="$class"
						/>
					@endforeach
				</div>
			</div>
		@endforeach
</x-layouts.class-dashboard>
