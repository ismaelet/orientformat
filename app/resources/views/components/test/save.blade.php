@props(['completed'])

@if ($completed && !isSupervisor())
	<x-button
		type="submit"
		name="submit"
		{{ $attributes->merge(['class' => '']) }}
	>{{ __('Save changes') }}</x-button>
@endif
