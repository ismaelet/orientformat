<div
	class="section group flex gap-2 bg-slate-100 transition-colors hover:bg-slate-200"
	style="--i: {{ $key }}"
>
	{{-- Icon --}}
	<div class="bg-(--_color) grid w-10 shrink-0 place-items-center rounded-sm">
		<x-dynamic-component
			:component="'icon-sections.section-' . $section->originalSection()->id"
			class="aspect-square w-2/3"
		/>
	</div>

	{{-- Result --}}
	<div class="grid grow cursor-default grid-cols-1 items-center py-2">
		<p class="font-medium italic leading-none">{{ $section->name }}</p>

		@if ($result !== null)
			<p>{{ $resultLabel }}: <span class="font-semibold">{{ $result }}</span></p>
		@else
			<p><span class="">Non ancora completata</span></p>
		@endif
	</div>

	@if ($result !== null)
		<form
			method="POST"
			class="flex grid-cols-1 content-center justify-items-end gap-2 px-2 opacity-0 transition-opacity group-hover:opacity-100"
			action="{{ $hasDependentTests ? route('test.reset.dependent', [$selfEvaluationTest->id]) : route('test.reset', [$selfEvaluationTest->id]) }}"
		>
			@csrf

			<a
				href="{{ $selfEvaluationTest->url($student->id, 'autovalutazioni') }}"
				class="flex items-center gap-1 font-semibold leading-none text-blue-500 transition-colors hover:text-blue-400"
				title="Visualizza il risultato"
			>
				<x-icon-eye class="w-7" />
			</a>

			@if ($userType === 'student')
				<button
					title="Ripeti l'autovalutazione"
					type="submit"
					class="flex cursor-pointer items-center gap-1 font-semibold leading-none text-red-500 transition-colors hover:text-red-400"
				>
					<x-icon-restart class="h-5" />
				</button>
			@endif
		</form>
	@endif
</div>
