@props(['completed'])

@if ($completed)
	<x-button
		type="submit"
		name="submit"
		{{ $attributes->merge(['class' => '']) }}
	>{{ __('Save changes') }}</x-button>
@endif
