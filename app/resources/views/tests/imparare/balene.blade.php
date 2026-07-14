@php
	$markerOptions = [];

	foreach ($helper->markers() as $markerKey => $marker) {
	    $markerOptions[] = [
	        'value' => 'marker' . $markerKey,
	        'label' => $marker['label'],
	    ];
	}
@endphp

@pushOnce('styles')
	<style>
		#text {
			width: fit-content;
			margin-inline: auto;
			position: relative;
			user-select: text;
		}

		[data-completed="false"] #text::selection {
			background: var(--color-amber-400);
		}

		[data-completed="false"]#text::-moz-selection {
			background: var(--color-amber-400);
		}

		[data-completed="false"] #text.is-selection-error::selection {
			background: var(--color-red-500);
		}

		[data-completed="false"] #text.is-selection-error::-moz-selection {
			background: var(--color-red-500);
		}

		.selectable.active {
			color: #000;
			background-color: color-mix(in hsl, var(--_type-color) 20%, transparent);
		}

		.selectable.active.wrong {
			background-color: var(--color-bad-400);
		}

		.selection-menu {
			position: fixed;
			z-index: 1000;
			display: grid;
			gap: 0.5rem;
			min-width: 14rem;
			padding: 0.75rem;
			border-radius: 0.75rem;
			background: #fff;
			box-shadow: 0 15px 40px -15px rgba(0, 0, 0, 0.35);
		}

		.selection-menu.hidden {
			display: none;
		}

		.selection-menu button {
			border: 0;
			border-radius: 0.5rem;
			padding: 0.75rem 1rem;
			text-align: left;
			cursor: pointer;
			background: var(--_type-color);
			transition: opacity 0.2s;
		}

		.selection-menu button:hover {
			opacity: 0.8;
		}

		.selection-menu button:disabled {
			opacity: 0.5;
			cursor: not-allowed;
		}

		.marker {
			display: flex;
			justify-content: center;
			align-items: center;
			padding: 1rem;
			background-color: var(--_type-color);
			border-radius: var(--radius-md);
			font-size: var(--text-lg);
			text-align: center;
			font-weight: var(--font-weight-medium);
		}

		.marker.inactive {
			opacity: 0.5;
			filter: grayscale(100%);
			pointer-events: none;
		}

		.marker:nth-child(1),
		.selection-menu button:nth-child(1),
		.selectable:has([value="marker0"]),
		[data-completed="true"] .selectable[data-text-type="marker0"] {
			--_type-color: #6bb1f9;
		}

		.marker:nth-child(2),
		.selection-menu button:nth-child(2),
		.selectable:has([value="marker1"]),
		[data-completed="true"] .selectable[data-text-type="marker1"] {
			--_type-color: #ffcf3b;
		}

		.marker:nth-child(3),
		.selection-menu button:nth-child(3),
		.selectable:has([value="marker2"]),
		[data-completed="true"] .selectable[data-text-type="marker2"] {
			--_type-color: hsl(253, 86%, 75%);
		}

		.marker:nth-child(4),
		.selection-menu button:nth-child(4),
		.selectable:has([value="marker3"]),
		[data-completed="true"] .selectable[data-text-type="marker3"] {
			--_type-color: #6dcf25;
		}

		.marker:nth-child(5),
		.selection-menu button:nth-child(5),
		.selectable:has([value="marker4"]),
		[data-completed="true"] .selectable[data-text-type="marker4"] {
			--_type-color: #f689d3;
		}

		.marker:nth-child(6),
		.selection-menu button:nth-child(6),
		.selectable:has([value="marker5"]),
		[data-completed="true"] .selectable[data-text-type="marker5"] {
			--_type-color: hsl(181, 94%, 66%);
		}

		[data-completed="true"] .selectable.correct {
			background-color: var(--_type-color);
		}

		[data-completed="true"] .selectable.incorrect {
			background-color: var(--color-red-500);
		}

		[data-completed="true"] .selectable:not(.correct):not(.incorrect) {
			border-bottom: 2px solid var(--_type-color);
		}

		[data-completed="false"] .selectable.active {
			background-color: color-mix(in hsl, var(--_type-color) 70%, transparent);
		}
	</style>
@endpushOnce

@pushOnce('scripts')
	<script>
		window.textSelectionOptions = @json($markerOptions);

		window.addEventListener('load', () => {
			window.initTextSelection?.();
		});
	</script>
@endpushOnce

<x-layouts.test
	:$title
	:$test
>
	<x-test.title
		:$test
		class="mt-8"
	/>

	<div
		class="mt-8 grid grid-cols-1 gap-8"
		data-completed="{{ $completed ? 'true' : 'false' }}"
		data-text-selection
	>
		<div class="grid grid-cols-1 gap-12">

			@if ($completed)
				{{-- Result --}}
				<div class="mb-4">
					<p class="text-center text-2xl">{!! __('tests.149-result', ['percentage' => $percentage]) !!}</p>

					<p class="mt-4 text-center text-lg">
						Qui sotto troverai <span class="bg-primary-200 font-semibold">evidenziate
							@if (count($helper->markers()) > 1)
								con i colori corretti
							@endif
						</span> le parti
						del testo che
						hai associato
						correttamente
						@if (count($helper->markers()) > 1)
							,
							<span class="bg-red-400 font-semibold text-gray-900">evidenziate in rosso</span> le parti che hai associato
							in modo errato
						@endif e
						<span class="border-b-2 font-semibold">sottolineate</span> le
						parti che non hai associato.
					</p>
				</div>
			@endif

			@if ($helper->showMarkerLabels)
				{{-- Markers --}}
				<div class="flex flex-wrap justify-center gap-4">
					@foreach ($helper->markers() as $markerKey => $marker)
						<div
							class="marker js-marker grow sm:max-w-60"
							data-marker-type="marker{{ $markerKey }}"
							data-max-count="{{ $marker['count'] }}"
						>
							<span>{!! $marker['label'] !!}</span>
						</div>
					@endforeach
				</div>
			@endif

			{{-- Text --}}
			<div class="">
				<x-heading.section class="text-center">{{ $helper->title ?? __('Text') }}</x-heading.section>

				<p
					id="text"
					class="js-text-block mt-4 text-lg leading-loose"
					data-selecting=""
					data-single-marker="{{ count($helper->markers()) == 1 ? 'true' : 'false' }}"
				>
					{!! $helper->htmlText($result) !!}
				</p>

				@if (!$completed)
					<div
						id="selection-menu"
						class="selection-menu js-selection-menu hidden"
						aria-hidden="true"
					>
					</div>
				@endif
			</div>
		</div>
	</div>

	<div class="mb-12 mt-8 grid grid-cols-1 justify-items-center gap-3 text-center">
		<x-test.button :test="$test" />
	</div>

</x-layouts.test>
