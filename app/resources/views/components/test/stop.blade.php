@props(['completed', 'text' => __('Skip this activity and resume it later')])

@if (!$completed)
	<label {{ $attributes->merge() }}>
		<button
			type="submit"
			class="hidden"
		></button>

		<p class="cursor-pointer italic">{{ $text }}</p>
	</label>
@endif
