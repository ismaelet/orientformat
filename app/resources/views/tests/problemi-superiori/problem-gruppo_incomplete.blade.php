<div class="">
	<x-test.title :$test />

	<div
		class="mt-12"
		x-data
	>
		@foreach ($helper::questions() as $key => $question)
			<div class="flex items-center justify-between gap-4 rounded-[100vw] px-6 py-4 odd:bg-gray-100">
				<p class="text-lg">{{ $key + 1 }}. {{ $question['text'] }}</p>

				<div class="js-question-options flex items-end gap-2">
					<input
						type="text"
						name="field[]"
						value=""
						class="js-question-answer js-field hidden"
					>

					@for ($i = 0; $i <= 4; $i++)
						<label class="group grid cursor-pointer justify-items-center">
							<input
								type="checkbox"
								name="field-{{ $key }}[]"
								value="{{ $i }}"
								class="js-question-option-input hidden"
								@change="selectOption($event)"
							>
							<span
								class="border-neutral-border question-option-radio group-hover:border-tertiary-400/50 group-has-[input:checked]:border-tertiary-400 grid aspect-square w-8 place-items-center rounded-full border-2 transition-colors"
							>
								<span
									class="question-option-dot aspect-square w-[40%] rounded-full opacity-0 transition-opacity group-hover:opacity-50 group-has-[input:checked]:opacity-100"
								></span>
							</span>
							<span class="font-semibold">{{ $i }}</span>
						</label>
					@endfor
				</div>
			</div>
		@endforeach
	</div>
</div>
