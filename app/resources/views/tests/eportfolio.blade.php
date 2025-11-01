@php
	$returnUrl = is_student()
	    ? route('activities.grades.show', ['grade' => student()->class->grade()])
	    : route('teacher.simulation');

	$lastMasterpiece = student()->masterpieces()->latest()->first();
@endphp

<x-layouts.main :$title>
	<div class="full-width mt-12 content-center">
		<div class="text-center">
			<x-heading.main>E-Portfolio e Esame di Stato</x-heading.main>
		</div>

		<div class="my-8 flex justify-center">
			<x-button
				href="{{ $returnUrl }}"
				variant="secondary"
			>Indietro</x-button>
		</div>

		<p class="text-lg leading-loose">Una parte importante dell’e-portfolio, con il quale ti presenterai all’esame di
			Stato, è
			costituita dai capolavori che hai
			prodotto e dalle autovalutazioni relative alle competenze acquisite. In questa sezione confluiscno i capolavori e le
			autovalutazioni, che nel tempo possono variare ed essere sostituiti. Una volta conclusi, li puoi trasferire
			nel sito del <a
				class="text-link"
				target="_blank"
				href="https://unica.istruzione.gov.it/portale/it/orientamento/il-tuo-percorso/e-portfolio"
			>MIM</a>.<br><br>
		</p>

		<div class="full-width bg-transition-400 mt-12 px-8 py-12">
			<div class="flex flex-wrap justify-between">
				<div class="grid grid-cols-1 gap-4 text-center">
					<x-heading.section class=""><span
							class="text-shadow-md text-white">Autovalutazioni</span></x-heading.section>
					<a
						class="font-heading flex items-center justify-center gap-2 self-end rounded border-2 py-4 text-lg font-semibold text-white transition-all hover:border-white hover:bg-white hover:text-neutral-700 sm:min-w-96"
						href="{{ route('students.self-assessments.pdf', $student) }}"
					>
						<x-icon-download class="h-6 w-6" />
						Scarica
					</a>
				</div>

				<div class="grid grid-cols-1 gap-4 text-center">
					<x-heading.section class=""><span class="text-shadow-md text-white">Capolavoro</span></x-heading.section>

					@if (!$lastMasterpiece)
						<p class="text-red-950">*Non hai ancora caricato un capolavoro</p>
					@endif

					<a
						class="font-heading @if ($lastMasterpiece) hover:border-white hover:bg-white hover:text-neutral-700 sm:min-w-96 @endif flex items-center justify-center gap-2 rounded border-2 py-4 text-lg font-semibold text-white transition-all"
						@if ($lastMasterpiece) href="{{ $lastMasterpiece->url() }}"
                        target="_blank"
                        rel="noopener" @endif
					>
						<x-icon-download class="h-6 w-6" />
						Scarica
					</a>
				</div>
			</div>
		</div>
	</div>

</x-layouts.main>
