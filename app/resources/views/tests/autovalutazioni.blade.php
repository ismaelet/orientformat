<x-layouts.main :$title>
	<div class="full-width content-center bg-slate-100 py-20">
		<div class="">
			@if (is_student())
				<x-student.autovalutazioni :$student />
			@else
				<div class="text-center">
					<x-heading.main>Autovalutazioni</x-heading.main>
					<p class="mt-12 text-2xl">Questa sezione è disponibile solo per gli studenti.</p>
				</div>
			@endif
		</div>
	</div>
</x-layouts.main>
