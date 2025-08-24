@pushOnce('styles')
	<style>
		.survey-grid {
			display: grid;
			grid-template-columns: minmax(0, 2fr) repeat(4, minmax(0, 1fr));
		}

		.survey-grid-header {
			display: grid;
			grid-template-columns: subgrid;
			grid-column: 1 / -1;
		}

		.survey-grid-row {
			display: grid;
			grid-template-columns: subgrid;
			grid-column: 1 / -1;
		}

		.survey-grid-row svg {
			display: none;
			width: 1rem;
			color: hsl(var(--color-success-400-hsl));
		}

		.survey-grid-row:has(:checked) p:first-child {
			display: none;
		}

		.survey-grid-row:has(:checked) svg {
			display: block;
		}
	</style>
@endPushOnce

<div class="survey-grid w-full gap-x-4 gap-y-2 text-center">
	{{-- Headers --}}
	<div class="survey-grid-header">
		<span></span>

		@foreach ($question['headers'] as $header)
			<span>{{ $header }}</span>
		@endforeach
	</div>

	{{-- Rows --}}
	@foreach ($question['options'] as $optionKey => $option)
		@php
			$optionLetter = chr($optionKey + 65);
		@endphp

		<div class="survey-grid-row grid justify-items-center">
			<div class="flex w-full gap-2 text-left">
				<p class="survey-grid-letter flex font-bold">{{ $optionLetter }}.</p>
				{!! embed_icon('correct') !!}
				<p class="">{{ $option }}</p>
			</div>

			@foreach ($question['headers'] as $headerKey => $header)
				<x-checkbox
					type="radio"
					name="{{ $letter }}-{{ $questionKey + 1 }}-{{ $optionLetter }}"
					value="{{ $header }}"
				/>
			@endforeach
		</div>
	@endforeach
</div>
