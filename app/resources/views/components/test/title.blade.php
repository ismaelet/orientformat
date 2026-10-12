@props(['test', 'description' => null])

<div {{ $attributes->merge() }}>

	{{-- Progress tracker --}}
	<p class="text-neutral-heading text-sm font-bold tracking-[0.2em]">
		{{ __('misc.section-progress', ['step' => $test->step, 'total' => $test->section->tests->count()]) }}</p>

	{{-- Title --}}
	<h1 class="text-800 text-neutral-heading font-semibold">{{ $test->name }}</h1>

	{{-- Description --}}
	@if ($description !== '')
		<p class="border-neutral-border text-neutral-text mt-4 border-t pt-4 text-lg">
			{!! $description ?: nl2br($test->description) !!}</p>
	@endif
</div>
