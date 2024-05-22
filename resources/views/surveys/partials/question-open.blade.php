@push('styles')
	<style>
		.survey-row:has(:checked) {
			background-color: hsl(var(--color-success-400-hsl) / .2);
		}
	</style>
@endpush

<div class="grid grid-cols-1 gap-2">
	@for ($i = 0; $i < 5; $i++)
		<div class="survey-row flex cursor-pointer items-center justify-between gap-4 transition-colors">
			@php
				$optionLetter = chr($i + 65);
			@endphp

			<p><strong>{{ $optionLetter }}.</strong></p>

			<x-inputs.input
				class="grow"
				name="{{ $letter }}-{{ $questionKey + 1 }}-{{ $optionLetter }}"
				placeholder="..."
			/>
		</div>
	@endfor
</div>
