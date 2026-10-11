@pushOnce('styles')
	<style>
		#memory-test [hidden] {
			display: none !important;
		}

		/* Number grid */
		#memory-test .memory-numbers {
			display: flex;
			justify-content: center;
			gap: 1.5rem;
			max-width: min(100%, calc(var(--size) * 6rem));
			margin-inline: auto;
		}

		#memory-test .memory-number {
			width: 100%;
			padding: 2rem 0;
			border: none;
			border-radius: 0.75rem;
			background-color: #f6f6f6;
			color: #222;
			font-size: clamp(1rem, 3vw, 2.5rem);
			font-weight: 700;
			text-align: center;
			box-shadow: inset -3px -5px 10px rgb(0 0 0 / 20%);
			transition:
				background-color 0.3s,
				box-shadow 0.3s,
				color 0.3s;
		}

		#memory-test .memory-number:focus {
			background-color: var(--color-primary-400);
			color: white;
			outline: none;
		}

		#memory-test .memory-number.correct {
			background-color: #15803d;
			color: white;
		}

		#memory-test .memory-number.incorrect {
			background-color: #dc2626;
			color: white;
		}

		#memory-test .memory-number::-webkit-inner-spin-button,
		#memory-test .memory-number::-webkit-outer-spin-button {
			-webkit-appearance: none;
			margin: 0;
		}

		#memory-test .memory-number {
			appearance: textfield;
			-moz-appearance: textfield;
		}

		/* Visual presentation */
		#memory-test .memory-view-text {
			font-size: clamp(1.5rem, 7vw, 5rem);
			line-height: 1.5;
			overflow-wrap: anywhere;
		}

		#memory-test .memory-dot {
			display: inline-block;
			font-size: 0.5em;
			vertical-align: middle;
		}

		/* Audio playback */
		#memory-test .memory-play {
			display: flex;
			align-items: center;
			justify-content: center;
			width: 8rem;
			height: 8rem;
			margin-inline: auto;
			border-radius: 50%;
			background-color: var(--color-primary-400);
			color: white;
			cursor: pointer;
			position: relative;
		}

		#memory-test .memory-play.is-playing::before {
			content: '';
			position: absolute;
			inset: 0;
			border-radius: 50%;
			background-color: var(--color-primary-400);
			animation: memory-pulse 1250ms infinite;
			z-index: -1;
		}

		@keyframes memory-pulse {
			0% {
				transform: scale(0.95);
				opacity: 0.75;
			}

			100% {
				transform: scale(1.35);
				opacity: 0;
			}
		}

		@media (max-width: 480px) {
			#memory-test .memory-numbers {
				gap: 0.25rem;
			}

			#memory-test .memory-number {
				border-radius: 0.3rem;
				font-size: clamp(0.875rem, 4vw, 1.5rem);
			}
		}
	</style>
@endPushOnce

@pushOnce('scripts')
	<script defer>
		document.addEventListener('DOMContentLoaded', () => {
			const root = document.getElementById('memory-test');

			if (!root) return;

			const find = selector => root.querySelector(selector);

			const previousPanel = find('#memory-previous');
			const inputPanel = find('#memory-input');
			const viewPanel = find('#memory-view');
			const listenPanel = find('#memory-listen');

			const audio = find('#memory-audio');
			const playButton = find('#memory-play');

			const panels = [
				previousPanel,
				inputPanel,
				viewPanel,
				listenPanel,
			].filter(Boolean);

			const numberInputs = root.querySelectorAll(
				'.js-memory-number'
			);

			function showPanel(panel) {
				panels.forEach(item => {
					item.hidden = item !== panel;
				});

				numberInputs.forEach(input => {
					input.disabled = panel !== inputPanel;
				});
			}

			function clearNumbers() {
				numberInputs.forEach(input => {
					input.value = '';
				});
			}

			function stopAudio() {
				if (!audio) return;

				audio.pause();
				audio.currentTime = 0;

				playButton?.classList.remove('is-playing');
			}

			// Continue after a correct answer
			root.querySelectorAll('.js-memory-continue')
				.forEach(button => {
					button.addEventListener('click', () => {
						showPanel(inputPanel);
					});
				});

			// Show the sequence visually
			find('#memory-show')?.addEventListener('click', () => {
				clearNumbers();
				showPanel(viewPanel);
			});

			// Switch to audio presentation
			find('#memory-listen-button')?.addEventListener(
				'click',
				() => {
					clearNumbers();
					showPanel(listenPanel);
				}
			);

			// Return to number entry
			root.querySelectorAll('.js-memory-back')
				.forEach(button => {
					button.addEventListener('click', () => {
						stopAudio();
						showPanel(inputPanel);
					});
				});

			// Play the audio
			playButton?.addEventListener('click', async () => {
				if (!audio) return;

				try {
					audio.currentTime = 0;
					await audio.play();
				} catch (error) {
					console.error('Audio playback failed', error);
				}
			});

			audio?.addEventListener('playing', () => {
				playButton?.classList.add('is-playing');
			});

			audio?.addEventListener('pause', () => {
				playButton?.classList.remove('is-playing');
			});

			audio?.addEventListener('ended', () => {
				playButton?.classList.remove('is-playing');
			});

			// Enable input validation only when the input panel
			// is active.
			numberInputs.forEach(input => {
				input.disabled = inputPanel?.hidden ?? true;

				input.addEventListener('input', () => {
					if (input.value.length > 1) {
						input.value = input.value.slice(0, 1);
					}
				});
			});
		});
	</script>
@endPushOnce

<x-layouts.test
	:$title
	:$test
>

	@php
		$previousLevel = $state['previousLevel'];
		$previousAnswers = $state['previousAnswers'];
		$currentLevel = $state['level'];
		$sequence = $state['sequence'];

		$showPrevious = $previousLevel > 0 && $previousAnswers !== [] && !$state['finished'];

		$section = $test->section;
		$mainSection = $section->originalSection();

		$audioUrl = client_path(
		    '/pages/assets/' .
		        $section->area->slug .
		        '/' .
		        $mainSection->slug .
		        '/' .
		        $test->slug .
		        '/audio' .
		        $currentLevel .
		        '.mp3',
		);
	@endphp

	<div
		id="memory-test"
		class="full-width mb-20 mt-20"
	>

		<x-test.title :$test />

		@if ($memoryAttempt?->completed)

			{{-- Completed test --}}
			<div class="py-10 text-center">

				<h2 class="text-3xl font-bold">
					{{ __('Test completed') }}
				</h2>

				<p class="mt-4 text-2xl">
					{{ $memoryAttempt->percentage }}%
				</p>

				<x-button
					href="{{ $test->nextUrl($student) }}"
					class="mt-8"
				>
					{{ __('Continue') }}
				</x-button>

			</div>
		@elseif ($state['finished'])
			{{-- All eight levels have been passed --}}
			<div class="py-10 text-center">

				<h2 class="text-3xl font-bold">
					{{ __('tests.163-right') }}
				</h2>

				<x-button
					type="submit"
					name="submit"
					value="1"
					formnovalidate
					class="mt-8"
				>
					{{ __('Continue') }}
				</x-button>

			</div>
		@else
			{{-- Previous attempt --}}
			@if ($showPrevious)

				<div
					id="memory-previous"
					class="py-8 text-center"
				>

					<div
						class="memory-numbers mb-8"
						style="--size: {{ count($previousAnswers) }}"
					>
						@foreach ($previousAnswers as $index => $answer)
							@php
								$expected = $helper::ANSWERS[$previousLevel][$index] ?? null;
								$correct = $answer === $expected;
							@endphp

							<div @class([
								'memory-number',
								'correct' => $correct,
								'incorrect' => !$correct,
							])>
								{{ $answer }}
							</div>
						@endforeach
					</div>

					@if ($state['right'])

						<x-button
							type="button"
							class="button js-memory-continue"
						>
							{{ __('Continue') }}
						</x-button>
					@else
						<div class="flex flex-col items-center gap-4">

							<x-button
								type="submit"
								name="reset"
								value="1"
								formnovalidate
								class="button"
							>
								{{ __('Try again') }}
							</x-button>

							@if (!isSupervisor())
								<button
									type="submit"
									name="submit"
									value="1"
									formnovalidate
								>
									{{ __('tests.163-stop') }}
								</button>
							@endif

						</div>

					@endif

				</div>

			@endif

			{{-- Current level --}}
			<div
				id="memory-input"
				@if ($showPrevious) hidden @endif
			>

				<div class="mb-8 grid grid-cols-2 justify-items-center gap-4">

					<x-button
						type="button"
						id="memory-show"
						variant="secondary"
						class="center-icon"
					>
						<x-icon-eye />
						{{ __('See') }}
					</x-button>

					<x-button
						type="button"
						id="memory-listen-button"
						variant="secondary"
						class="center-icon"
					>
						<x-icon-ear />
						{{ __('Listen') }}
					</x-button>

				</div>

				<div
					class="memory-numbers"
					style="--size: {{ count($sequence) }}"
				>

					@foreach ($sequence as $index => $number)
						<input
							type="number"
							name="field[]"
							min="0"
							max="9"
							step="1"
							inputmode="numeric"
							autocomplete="off"
							required
							class="memory-number js-memory-number"
							aria-label="{{ __('Number') }} {{ $index + 1 }}"
						>
					@endforeach

				</div>

				{{-- User submission section --}}
				<div class="mt-8 flex flex-col items-center gap-4">
					<x-button
						type="submit"
						name="check"
						value="1"
						class="button"
					>
						{{ __('Confirm') }}
					</x-button>

					@if (!isSupervisor())
						<button
							type="submit"
							name="submit"
							value="1"
							formnovalidate
						>
							{{ __('tests.163-stop') }}
						</button>
					@endif

				</div>

				@error('field')
					<p class="mt-4 text-center text-red-600">
						{{ $message }}
					</p>
				@enderror
			</div>

			{{-- Visual sequence presentation --}}
			<div
				id="memory-view"
				class="py-10 text-center"
				hidden
			>

				<h2 class="memory-view-text font-bold">

					@foreach ($sequence as $number)
						@if (!$loop->first)
							<span class="memory-dot">
								&middot;
							</span>
						@endif

						{{ $number }}
					@endforeach

				</h2>

				<x-button
					type="button"
					class="js-memory-back mt-8"
				>
					{{ __('tests.163-insert') }}
				</x-button>

			</div>

			{{-- Audio sequence presentation --}}
			<div
				id="memory-listen"
				class="py-10 text-center"
				hidden
			>

				<audio
					id="memory-audio"
					preload="none"
				>
					<source
						src="{{ $audioUrl }}"
						type="audio/mpeg"
					>
					{{ __('mp3-error') }}
				</audio>

				<button
					type="button"
					id="memory-play"
					class="memory-play"
					aria-label="{{ __('Listen') }}"
				>
					<x-icon-play class="h-8 w-8" />
				</button>

				<x-button
					type="button"
					class="js-memory-back mt-20"
				>
					{{ __('tests.163-insert') }}
				</x-button>

			</div>

		@endif
	</div>
</x-layouts.test>
