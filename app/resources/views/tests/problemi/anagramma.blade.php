@pushOnce('styles')
	<style>
		.riddles {
			display: grid;
			gap: 2rem;
			width: fit-content;
			margin-inline: auto;
		}

		.riddle {
			display: grid;
			grid-template-columns: max-content 1fr max-content;
			align-items: center;
			gap: 1.5rem;
			padding: 1rem;
			border-radius: var(--radius-md);
			box-shadow: var(--shadow-400);
		}

		.riddle__definition {
			padding-inline: 1.5rem;
			border: 1px solid var(--color-neutral-border);
			border-width: 0 1px;
			text-align: center;
		}

		.riddle__anagram {
			font-size: var(--text-2xl);
			font-weight: var(--font-weight-bold);
		}

		.test-input--wrong,
		.test-input--correct {
			text-align: center;
			font-weight: var(--font-weight-semibold);
		}

		.test-input--wrong {
			border: 2px solid var(--color-error-400) !important;
			color: var(--color-error-400) !important;
		}

		.test-input--correct {
			border: 2px solid var(--color-success-500) !important;
			color: var(--color-success-500) !important;
		}
	</style>
@endpushOnce

<x-layouts.test
	:$title
	:$test
>
	<x-test.title :$test />

	<div class="page-content">
		<div class="riddles">

			@foreach ($helper->riddles as $key => $riddle)
				<div class="riddle">
					<p class="riddle__anagram">{{ $riddle[0] }}</p>
					<p class="riddle__definition text-lg">{{ $riddle[1] }}</p>

					@if ($completed)
						<p
							class="{{ strtoupper($result[$key]) == $riddle[2] ? 'test-input--correct' : 'test-input--wrong' }} min-w-[20ch] rounded bg-neutral-100 px-2 py-1 text-lg"
						>{{ $completed ? strtoupper($result[$key]) : null }}</p>
					@else
						<input
							type="text"
							class="js-field rounded bg-neutral-100 px-2 py-1 text-lg"
							name="field[]"
							placeholder="Parola"
							:readonly="isSupervisor()"
						>
					@endif
				</div>
			@endforeach
		</div>
	</div>

	<div class="grid grid-cols-1 content-start gap-4">
		<x-test.button
			:$test
			:progressive="true"
		/>

		<x-test.stop :$completed />
	</div>
</x-layouts.test>
