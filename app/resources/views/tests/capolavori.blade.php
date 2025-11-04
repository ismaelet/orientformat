@php
	$returnUrl = is_student()
	    ? route('activities.grades.show', ['grade' => student()->class->grade()])
	    : route('teacher.simulation');
@endphp

<x-layouts.main :$title>
	<div class="mb-20 mt-12 grid grid-cols-1 gap-8">
		<div class="text-center">
			<x-heading.main>Capolavori</x-heading.main>
		</div>

		@if (is_student())
			<div class="flex justify-center">
				<x-button
					href="{{ $returnUrl }}"
					variant="secondary"
				>Indietro</x-button>
			</div>

			@session('success')
				<x-alerts.success>
					{{ session('success') }}
				</x-alerts.success>
			@endsession

			<p class="text-lg">Un “capolavoro” è un prodotto realizzato in ambiente scolastico o extra-scolastico, attraverso
				attività svolte
				individualmente oppure in gruppo.
				Il capolavoro è importante perché dimostra un qualche progresso o una maggiore competenza in qualche tipo di
				attività.
				Puoi inserire anche
				più capolavori nel corso dell’anno, procedendo in questo modo: dai un titolo al tuo capolavoro, seleziona la
				tipologia
				di attività in cui è nato e
				collegalo ad una competenza che hai sviluppato. Infine carica l’allegato in un formato PDF.<br><br>

				I capolavori che riterrai più importanti (al massimo tre per ogni anno scolastico), li potrai inserire nel tuo
				e-portfolio nel sito <a
					class="text-link"
					target="_blank"
					href="https://unica.istruzione.gov.it/portale/it/orientamento/il-tuo-percorso/e-portfolio"
				>UNICA</a>.<br><br>


				<span class="text-error-400">A conclusione dell’anno scolastico i capolavori saranno rimossi da questo sito.</span>
			</p>

			<livewire:tests.capolavori.table />

			<livewire:tests.capolavori.upload-form />
		@else
			<div class="text-center">
				<p class="mt-12 text-2xl">Questa sezione è disponibile solo per gli studenti.</p>
			</div>
		@endif
	</div>

</x-layouts.main>
