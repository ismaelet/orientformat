<x-layouts.main :$title>
	<div class="breakout my-20">
		<x-heading.main class="max-w-200 mx-auto text-center">{{ $title }}</x-heading.main>

		<div class="mt-12">
			<p>Per favorire l’interpretazione delle autovalutazioni effettuate dallo studente abbiamo inserito in ambiente
				studente la funzione “Saperne di più”,
				mentre in ambiente docente si possono utilizzare due funzioni: “Saperne di più”- docente, che fornisce un quadro
				interpretativo della specifica
				competenza e quindi anche delle prestazioni ad essa connesse, e, in “Progresso studenti”, la funzione contrassegnata
				con una “i”, che segnala
				brevemente gli aspetti cui dedicare particolare attenzione nel proporre l’attività e nel valutarne gli esiti. Qui
				proponiamo un approfondimento più di
				carattere tecnico.</p>
		</div>

		<div class="mt-12 grid grid-cols-1 gap-12">
			@foreach ($structure as $areaKey => $area)
				<div class="area grid grid-cols-1 gap-8">
					<x-heading.section>{{ $areaKey + 1 }}. {{ $area['title'] }}</x-heading.section>

					@foreach ($area['sections'] as $sectionKey => $section)
						<div class="grid gap-8 lg:grid-cols-2">
							<div class="grid grid-cols-1 content-center gap-4">
								<x-heading.component>{{ $areaKey + 1 }}.{{ $sectionKey + 1 }}. {{ $section['title'] }}</x-heading.component>
								<p class="text-lg">{!! $section['text'] !!}</p>
							</div>

							<img
								src="{{ Vite::image('read/result-' . $areaKey + 1 . '-' . ($sectionKey + 1) . '.webp') }}"
								alt=""
								class="border border-slate-200 shadow-lg"
							>
						</div>
					@endforeach
				</div>
			@endforeach
		</div>
	</div>
</x-layouts.main>
