<x-layouts.main :$title>
	<div class="full-width bg-slate-100">
		<div class="breakout content-center py-20">
			@if (is_student())
				<x-student.poi :$student />
			@else
				<div class="text-center">
					<x-heading.main>POI</x-heading.main>
					<p class="mt-12 text-2xl">Questa sezione è disponibile solo per gli studenti.</p>
				</div>
			@endif
		</div>
	</div>
</x-layouts.main>
