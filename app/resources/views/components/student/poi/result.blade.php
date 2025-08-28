<div class="result">
	<div class="result__icon">
		<x-dynamic-component
			:component="'icon-sections.section-' . $section->id"
			class="h-1/2 w-1/2"
		/>
	</div>

	<div class="result__content">
		<h3 class="result__title">Risultato della sezione <span class="font-normal italic">"{{ $name }}"</span>:</h3>
		<p class="answer">
			@if ($result)
				{{ $description ?: 'Risultato dell\'autovalutazione' }}: <span class="font-semibold">{{ $result }}</span>
			@else
				<span class="font-semibold">non ancora completata</span>
			@endif
		</p>
	</div>
</div>
