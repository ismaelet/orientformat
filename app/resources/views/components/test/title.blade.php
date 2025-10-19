@props(['test'])

<div>
	{{-- Progress tracker --}}
	<p class="text-tertiary-400 text-sm font-bold tracking-[0.2em]">
		{{ __('misc.section-progress', ['step' => $test->step, 'total' => $test->section->tests->count()]) }}</p>

	<h1 class="text-800 text-tertiary-400 font-semibold">{{ $test->name }}</h1>

	<p class="border-neutral-border mt-4 border-t pt-4 text-lg">
		{{ nl2br($test->description) }}</p>
</div>
