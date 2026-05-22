@pushOnce('styles')
	<style>
		.answer {
			font-size: var(--text-lg);
			line-height: 2;
			text-align: center;
		}

		.result {
			margin-top: 2rem;
			font-size: var(--text-2xl);
			text-align: center;
		}

		.result--correct {
			color: var(--color-success-500);
		}

		.result--wrong {
			color: var(--color-error-500);
		}
	</style>
@endpushOnce

<x-layouts.test
	:$title
	:$test
>
	<x-test.title
		:$test
		class="mt-20"
	/>

	<div class="grid grid-cols-1 gap-8">

		@if ($completed)
			<p class="result {{ $percentage == 100 ? 'result--correct' : 'result--wrong' }}">
				{{ $percentage == 100 ? 'La soluzione è corretta!' : 'La soluzione è sbagliata, ma puoi riprovare quando vuoi' }}
			</p>
		@else
			<x-input
				type="number"
				class="answer js-field bg-neutral-100! mt-8"
				name="field[]"
				placeholder="Risposta"
			/>
		@endif

		<div class="grid grid-cols-1 gap-4">
			<x-test.button :$test />
			<x-test.stop :$completed />
		</div>

		<x-test.redo
			:$test
			:$completed
		/>
	</div>

	<div class="page__content">
		<img
			src="{{ Vite::image('tests/problemi-esperto/gomme-image.webp') }}"
			alt=""
		>
	</div>
</x-layouts.test>
