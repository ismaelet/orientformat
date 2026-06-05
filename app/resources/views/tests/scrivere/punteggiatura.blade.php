@pushOnce('styles')
	<style>
		.sentence {
			font-size: var(--text-xl);
		}

		.sentence select {}

		.sentence select {
			width: 2.5rem;
			height: 1.5em;
			padding-inline: 0;
			opacity: 1;
			background-color: var(--color-slate-50);
			border-radius: var(--radius-sm);
			line-height: 1.5;
			font-size: var(--text-xl);
			cursor: pointer;

			&:has(option:checked[value="0"]) {
				background-color: var(--color-slate-200);
			}
		}

		.answer {
			display: inline-block;
			min-width: 1em;
			border-radius: var(--radius-sm);
			cursor: default;
		}

		.answer-right {
			background-color: var(--color-success-100);
			color: var(--color-success-700);
		}

		.answer-wrong {
			background-color: var(--color-error-100);
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
		class="mt-8"
	/>

	<div class="sentences mt-16 grid grid-cols-1 gap-8">

		@if ($completed)
			@foreach ($helper->completedText($result) as $key => $sentence)
				<p class="sentence"><span class="font-bold">{{ $key + 1 }}.</span> {!! $sentence !!}</p>
			@endforeach
		@else
			@foreach ($helper->sentences() as $key => $sentence)
				<p class="sentence"><span class="font-bold">{{ $key + 1 }}.</span> {!! $sentence !!}</p>
			@endforeach
		@endif
	</div>

	<div class="mb-20 mt-16 grid grid-cols-1 justify-items-center gap-4 self-end">
		<div class="w-full">
			<x-test.button
				class="w-full"
				:test="$test"
				:progressive="true"
			/>
			<x-test.stop :$completed />
		</div>

		<x-test.redo
			:$test
			:$completed
		/>
	</div>

</x-layouts.test>
