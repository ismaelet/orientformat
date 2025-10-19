@pushOnce('styles')
	<style>
		.question-option-radio {
			label:nth-of-type(1) & {
				width: 1.5rem;
			}

			label:nth-of-type(2) & {
				width: 1.75rem;
			}

			label:nth-of-type(3) & {
				width: 2rem;
			}

			label:nth-of-type(4) & {
				width: 2.25rem;
			}

			label:nth-of-type(5) & {
				width: 2.5rem;
			}
		}

		.question-option-dot {
			label:nth-of-type(1) & {
				background-color: oklch(65% 0.245 27.325);
			}

			label:nth-of-type(2) & {
				background-color: oklch(70% 0.245 70.325);
			}

			label:nth-of-type(3) & {
				background-color: oklch(75.7% 0.245 90);
			}

			label:nth-of-type(4) & {
				background-color: oklch(70.7% 0.245 110);
			}

			label:nth-of-type(5) & {
				background-color: oklch(65% 0.245 135);
			}
		}
	</style>
@endpushOnce

@pushOnce('scripts')
	<script defer>
		function selectOption(event) {
			const input = event.target;
			const value = input.value;
			const optionsContainer = input.closest('.js-question-options');
			const allOptions = optionsContainer.querySelectorAll('.js-question-option-input');
			const answerField = optionsContainer.querySelector('.js-question-answer');

			allOptions.forEach(option => {
				if (option !== input) {
					option.checked = false;
				}
			});

			// Set the answer field value to the selected option value
			answerField.value = value;

			// Trigger input event to update the progressive button
			answerField.dispatchEvent(new Event('input'));
		}
	</script>
@endpushOnce

<x-layouts.test
	:$title
	:$test
>
	<div class="mb-20 mt-10">

		@includeWhen(!$completed, 'tests.problemi-superiori.problem-gruppo_incomplete')
		@includeWhen($completed, 'tests.problemi-superiori.problem-gruppo_completed')

		<x-test.button
			:$test
			:progressive="true"
			class="mt-8 w-full"
		/>
	</div>
</x-layouts.test>
