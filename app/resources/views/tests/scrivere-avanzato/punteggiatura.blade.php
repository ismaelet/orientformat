@pushOnce('styles')
	<style>
		.text {
			font-size: var(--fs-450);
			line-height: 2.5;
		}

		.text select {
			width: 2.5rem;
			height: 1.5em;
			padding-inline: 0;
			margin-inline: .25em;
			opacity: 1;
			background-color: var(--color-slate-100);
			border-radius: var(--radius-sm);
			line-height: 1.5;
			font-size: var(--fs-600);
			cursor: pointer;
		}

		.text select.right {
			color: var(--color-green-600);
			cursor: default;
		}

		.text select.wrong {
			color: var(--color-red-600);
			cursor: default;
		}

		.result {
			font-size: var(--fs-450);
			text-align: center;
		}

		.result span {
			font-weight: var(--fw-bold);
		}
	</style>
@endpushOnce

<x-layouts.test
	:$title
	:$test
>
	<x-test.title
		:$test
		class="mt-8"
	/>

	@if ($completed)
		<p class="mx-auto text-lg">Hai inserito il <span @class([
			'font-bold',
			'text-red-600' => $percentage < 50,
			'text-green-600' => $percentage >= 50,
		])>{{ $percentage }}%</span> dei segni di
			punteggiatura
			corretti.
		</p>
	@endif

	<div
		class="text grid"
		data-spacing="700"
	>
		<p class="text">{!! $helper->htmlText() !!}</p>
	</div>

	<div>
		<div class="grid grid-cols-1 justify-items-center gap-2">
			<x-test.button
				@class(['w-full' => !$completed])
				:test="$test"
				:progressive="true"
			/>

			{{ skip() }}

			<x-test.redo
				:$test
				:$completed
			/>
		</div>
	</div>

</x-layouts.test>
