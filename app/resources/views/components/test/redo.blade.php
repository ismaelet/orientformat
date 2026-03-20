@props(['test', 'completed'])

@if ($completed && !isSupervisor())
	<button
		type="submit"
		formaction="{{ route('test.reset', $test) }}"
		class="flex items-center justify-center gap-2 transition-colors hover:text-red-600"
	>
		<x-icon-replay class="h-4 w-4 shrink-0" />
		{{ __('Try again') }}
	</button>
@endif
