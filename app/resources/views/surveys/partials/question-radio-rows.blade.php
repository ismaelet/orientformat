@pushOnce('styles')
	<style>
		.survey-row:has(:checked) {
			background-color: hsl(var(--color-success-400-hsl) / .2);
		}
	</style>
@endPushOnce

<div class="grid grid-cols-1 gap-2">
	@foreach ($question['options'] as $optionKey => $option)
		<label class="survey-row flex cursor-pointer justify-between gap-4 transition-colors">
			<p><strong>{{ chr($optionKey + 65) }}.</strong> {{ $option }}</p>
			<x-checkbox
				type="radio"
				name="{{ $letter }}-{{ $questionKey + 1 }}"
				value="{{ $option }}"
			/>
		</label>
	@endforeach
</div>
