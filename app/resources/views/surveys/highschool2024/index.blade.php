<x-layouts.main>
	<form
		class="my-20 grid gap-16"
		method="POST"
	>
		<div class="text-center">
			<x-typography.section-heading>
				Valutazione<br>Conclusiva
			</x-typography.section-heading>
			<x-typography.main-subheading>
				Sperimentazione secondaria di primo e secondo grado
			</x-typography.main-subheading>
		</div>

		<p>Ci interessa avere una tua valutazione sul percorso fatto.</p>

		<div class="questions grid grid-cols-1 gap-12">
			@foreach ($questionAreas as $areaKey => $questionArea)
				@include('surveys.partials.question-area', ['questionArea' => $questionArea, 'areaKey' => $areaKey])
			@endforeach
		</div>

		<p>Grazie per la collaborazione.</p>

		<x-inputs.button type="submit">Invia</x-inputs.button>
	</form>
</x-layouts.main>
