@pushOnce('styles')
	<style>
		.survey-complex-grid {
			display: grid;
			grid-template-columns: max-content repeat(3, minmax(0, 1fr));
		}

		.survey-complex-row {
			display: grid;
			grid-template-columns: subgrid;
			grid-column: 1 / -1;
		}

		.survey-complex-row>p:first-child {
			grid-row: inherit;
			writing-mode: vertical-rl;
			text-orientation: mixed;
			rotate: 180deg;
		}

		.survey-grid-subrow svg {
			display: none;
			width: 1rem;
			color: hsl(var(--color-success-400-hsl));
		}

		.survey-grid-subrow:has(:checked) p:first-child {
			display: none;
		}

		.survey-grid-subrow:has(:checked) svg {
			display: block;
		}

		.survey-grid-subrow {
			display: grid;
			grid-template-columns: subgrid;
			grid-column: 2 / -1;
		}
	</style>
@endPushOnce

<div class="survey-complex-grid w-full gap-x-4 gap-y-8">
	{{-- Headers --}}
	<div class="survey-grid-header">
		@foreach ($question['headers'] as $key => $header)
			<span class="{{ $key > 1 ? 'text-center' : '' }} text-lg font-bold">{{ $header }}</span>
		@endforeach
	</div>

	{{-- Rows --}}
	@foreach ($question['rows'] as $rowKey => $row)
		<div
			class="survey-complex-row items-center"
			style="grid-row: span {{ count($row['options']) }};"
		>
			<p class="text-center font-bold">{{ $row['title'] }}</p>

			@foreach ($row['options'] as $optionKey => $option)
				@php
					$optionLetter = chr($optionKey + 65);
				@endphp

				<div class="survey-grid-subrow grid justify-items-center">
					<div class="flex w-full gap-2 text-left">
						<p class="survey-grid-letter flex font-bold">{{ $optionLetter }}.</p>
						{!! embed_icon('correct') !!}
						<p class="">{{ $option }}</p>
					</div>

					@foreach ($question['headers'] as $headerKey => $header)
						@if ($headerKey > 1)
							<x-checkbox
								type="radio"
								name="{{ $letter }}-{{ $questionKey + 1 }}-{{ $row['title'] }}-{{ $optionLetter }}"
								value="{{ $header }}"
							/>
						@endif
					@endforeach
				</div>
			@endforeach
		</div>
	@endforeach
</div>
