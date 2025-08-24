<div class="flex w-full flex-wrap justify-between gap-x-8 gap-y-4 lg:flex-nowrap">
	@foreach ($question['options'] as $optionKey => $option)
		<x-checkbox
			type="checkbox"
			name="{{ $letter }}-{{ $questionKey + 1 }}[]"
			value="{{ $option }}"
			text="{{ $option }}"
		/>
	@endforeach
</div>
