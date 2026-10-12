@pushOnce('styles')
	<style>
		#emotion-wheel {
			--face-size: clamp(5rem, 10vw, 10rem);
		}

		#emotion-wheel .wheel-layout {
			display: grid;
			grid-template-columns: 1fr;
			gap: 4rem;
			align-items: center;
		}

		@media (min-width: 60rem) {
			#emotion-wheel .wheel-layout {
				grid-template-columns:
					var(--face-size) minmax(0, 1fr) var(--face-size);
				gap: 2rem;
			}
		}

		#emotion-wheel .mouth-list {
			display: flex;
			flex-wrap: wrap;
			justify-content: center;
			gap: 0.75rem;
		}

		@media (min-width: 60rem) {
			#emotion-wheel .mouth-list {
				flex-direction: column;
				align-items: center;
			}
		}

		#emotion-wheel .face {
			position: relative;
			overflow: hidden;
			width: var(--face-size);
			aspect-ratio: 1;
			padding: 0.8rem;
			border-radius: 50%;
			background: var(--color-background, white);
			box-shadow: 0 0 1rem rgb(0 0 0 / 12%);
		}

		#emotion-wheel .face img {
			width: 100%;
			object-fit: contain;
			mix-blend-mode: multiply;
			pointer-events: none;
		}

		#emotion-wheel .mouth-choice {
			padding: .5rem;
			transition:
				opacity 0.2s,
				transform 0.2s;
		}

		#emotion-wheel .mouth-choice-wrapper {
			position: relative;
			width: var(--face-size);
			background-color: var(--color-background, white);
			padding: 0.8rem;
			border-radius: 50%;
			box-shadow: 0 0 1rem rgb(0 0 0 / 12%);
			cursor: grab;
		}

		#emotion-wheel .mouth-choice:hover {
			transform: scale(1.05);
		}

		#emotion-wheel .mouth-choice.selected .mouth-choice-wrapper {
			outline: 3px solid var(--color-primary-400);
			outline-offset: 3px;
		}

		#emotion-wheel .mouth-choice img {
			width: 100%;
			aspect-ratio: 1;
			object-fit: contain;
			pointer-events: none;
		}

		#emotion-wheel .mouth-choice:focus-visible,
		#emotion-wheel .face-target:focus-visible {
			outline: 3px solid var(--color-primary-400);
			outline-offset: 3px;
		}

		#emotion-wheel .wheel {
			position: relative;
			width: 100%;
			max-width: 48rem;
			aspect-ratio: 1;
			margin: 2rem auto;
			border: 2px dashed var(--color-tertiary-400);
			border-radius: 50%;
		}

		#emotion-wheel .wheel-description {
			position: absolute;
			top: 50%;
			left: 50%;
			width: 60%;
			transform: translate(-50%, -50%);
			text-align: center;
			font-size: clamp(0.75rem, 1.6vw, 1.125rem);
			line-height: 1.5;
		}

		#emotion-wheel .emotion-position {
			--angle: calc((var(--i) - 1) * 45deg);
			position: absolute;
			left: calc(50% + cos(var(--angle)) * 50%);
			top: calc(50% + sin(var(--angle)) * 50%);
			transform: translate(-50%, -50%);
			width: var(--face-size);
			z-index: 1;
		}

		#emotion-wheel .face-target {
			border: none;
			cursor: pointer;
		}

		#emotion-wheel .face-target.active {
			outline: 3px solid var(--color-primary-400);
			outline-offset: 3px;
		}

		#emotion-wheel .emotion-label {
			position: absolute;
			top: 100%;
			display: block;
			width: max(100%, 8rem);
			max-width: 11rem;
			margin: 0.75rem 50% 0;
			padding: 0.5rem;
			transform: translateX(-50%);
			border: 1px solid var(--color-tertiary-400);
			border-radius: 0.375rem;
			background: white;
			color: #222;
			text-align: center;
		}

		#emotion-wheel .completed-face {
			width: min(16rem, 100%);
			margin-inline: auto;
		}

		@media (max-width: 40rem) {
			#emotion-wheel {
				--face-size: clamp(2.5rem, 12vw, 4rem);
			}

			#emotion-wheel .wheel {
				margin-block: 1.5rem;
			}

			#emotion-wheel .wheel-description {
				width: 40%;
				font-size: 0.7rem;
			}

			#emotion-wheel .emotion-label {
				width: 6rem;
				min-width: 0;
				font-size: 0.75rem;
			}
		}
	</style>
@endPushOnce

@pushOnce('scripts')
	<script defer>
		document.addEventListener('DOMContentLoaded', () => {
			const root = document.getElementById('emotion-wheel');

			if (!root) return;

			const faceInput = root.querySelector('.js-chosen-face');
			const mouthInput = root.querySelector('.js-chosen-mouth');
			const emotionInput = root.querySelector('.js-chosen-emotion');
			const submitButton = root.querySelector('.js-emotion-submit');

			const mouths = root.querySelectorAll('.js-mouth-choice');
			const faces = root.querySelectorAll('.js-face-target');
			const labels = root.querySelectorAll('.js-emotion-label');

			let selectedMouth = null;
			let selectedFace = null;

			function updateSubmit() {
				if (!submitButton) return;

				submitButton.disabled = !(
					faceInput.value &&
					mouthInput.value &&
					emotionInput.value.trim()
				);
			}

			function selectMouth(mouth) {
				selectedMouth = mouth;

				mouths.forEach(item => {
					item.classList.toggle(
						'selected',
						item === mouth
					);
					item.setAttribute(
						'aria-pressed',
						item === mouth ? 'true' : 'false'
					);
				});
			}

			function selectFace(face) {
				if (!selectedMouth) return;

				resetFaces();

				selectedFace = face;

				const faceId = face.dataset.id;
				const mouthId = selectedMouth.dataset.id;
				const image = selectedMouth.querySelector('img');
				const target = face.querySelector('.js-face-mouth');
				const label = face.closest('.emotion-position')
					.querySelector('.js-emotion-label');

				target.src = image.src;
				target.hidden = false;

				face.classList.add('active');
				face.setAttribute('aria-pressed', 'true');

				faceInput.value = faceId;
				mouthInput.value = mouthId;

				label.hidden = false;
				label.focus();

				updateSubmit();
			}

			function resetFaces(resetMouth = false) {
				selectedFace = null;

				faces.forEach(face => {
					face.classList.remove('active');
					face.setAttribute('aria-pressed', 'false');

					const mouth = face.querySelector('.js-face-mouth');

					mouth.removeAttribute('src');
					mouth.hidden = true;
				});

				if (resetMouth) {
					mouths.forEach(mouth => {
						mouth.classList.remove('selected');
						mouth.setAttribute('aria-pressed', 'false');
					});
				}

				labels.forEach(label => {
					label.value = '';
					label.hidden = true;
				});

				faceInput.value = '';
				mouthInput.value = '';
				emotionInput.value = '';

				updateSubmit();
			}

			mouths.forEach(mouth => {
				mouth.addEventListener('click', () => {
					selectMouth(mouth);
				});

				mouth.addEventListener('dragstart', event => {
					selectMouth(mouth);

					event.dataTransfer.setData(
						'text/plain',
						mouth.dataset.id
					);

					event.dataTransfer.effectAllowed = 'copy';
				});
			});

			faces.forEach(face => {
				face.addEventListener('click', () => {
					selectFace(face);
				});

				face.addEventListener('dragover', event => {
					event.preventDefault();
					event.dataTransfer.dropEffect = 'copy';
				});

				face.addEventListener('drop', event => {
					event.preventDefault();

					const mouthId = event.dataTransfer.getData(
						'text/plain'
					);

					const mouth = [...mouths].find(
						item => item.dataset.id === mouthId
					);

					if (!mouth) return;

					selectMouth(mouth);
					selectFace(face);
				});
			});

			labels.forEach(label => {
				label.addEventListener('input', () => {
					if (selectedFace?.closest('.emotion-position')
						.contains(label)) {
						emotionInput.value = label.value;

						updateSubmit();
					}
				});
			});

			root.querySelectorAll('.js-emotion-reset')
				.forEach(button => {
					button.addEventListener('click', () => {
						resetFaces(true);
					});
				});

			updateSubmit();
		});
	</script>
@endPushOnce

<x-layouts.test
	:$title
	:$test
>

	@php
		$showCompleted = $faceAttempt?->completed && !$choosingAgain;

		$eyeAsset = fn(int $id) => public_asset("test-volti/eye-{$id}.png");

		$mouthAsset = fn(int $id) => public_asset("test-volti/mouth-{$id}.png");
	@endphp

	<x-test.title
		:$test
		description=""
		class="mb-12 mt-20 text-center"
	/>

	<section
		id="emotion-wheel"
		class="breakout my-16"
	>

		<form
			method="POST"
			action="{{ route('test.store', ['test' => $test->slug_with_id]) }}"
		>
			@csrf

			@if ($showCompleted)

				{{-- Completed state --}}
				<div class="grid justify-items-center gap-8">

					<p class="text-center text-xl font-bold">
						{{ __('You have chosen the following emotion:') }}
					</p>

					<div class="face stack-content completed-face grid">

						<img
							class="self-start"
							src="{{ $eyeAsset($faceSelection['face']) }}"
							alt=""
						>

						<img
							class="self-end"
							src="{{ $mouthAsset($faceSelection['mouth']) }}"
							alt=""
						>

					</div>

					<p class="text-success text-center text-2xl font-semibold">
						{{ $faceSelection['emotion'] }}
					</p>

					@if (!isSupervisor())
						<x-button
							type="submit"
							name="redo"
							value="1"
							variant="secondary"
							color="danger"
							class="center-icon"
						>
							<x-icon-refresh />
							{{ __('Choose another emotion') }}
						</x-button>
					@endif

					<x-test.button :$test />

				</div>
			@elseif (isSupervisor())
				<div class="py-10 text-center">
					{{ __('No results available') }}
				</div>
			@else
				{{-- Selection state --}}
				<div class="wheel-layout">

					{{-- Mouths 1–4 --}}
					<div class="mouth-list">
						@for ($i = 1; $i <= 4; $i++)
							<button
								type="button"
								class="mouth-choice js-mouth-choice"
								data-id="{{ $i }}"
								draggable="true"
								aria-label="Bocca {{ $i }}"
								aria-pressed="false"
							>
								<div class="mouth-choice-wrapper">
									<img
										src="{{ $mouthAsset($i) }}"
										alt=""
										draggable="false"
									/>
								</div>
							</button>
						@endfor
					</div>

					{{-- Circular faces --}}
					<div class="wheel">

						<p class="wheel-description">
							{{ $test->description }}
						</p>

						@for ($i = 1; $i <= 8; $i++)
							<div
								class="emotion-position"
								style="--i: {{ $i }}"
								data-id="{{ $i }}"
							>
								<button
									type="button"
									class="face stack-content face-target js-face-target grid"
									data-id="{{ $i }}"
									aria-label="Volto {{ $i }}"
									aria-pressed="false"
								>
									<img
										class="self-start"
										src="{{ $eyeAsset($i) }}"
										alt=""
									>

									<img
										class="js-face-mouth self-end"
										alt=""
										hidden
									>
								</button>

								<input
									type="text"
									class="emotion-label js-emotion-label"
									placeholder="{{ __('Emotion') }}"
									maxlength="18"
									aria-label="Emozione del volto {{ $i }}"
									hidden
								>

							</div>
						@endfor

					</div>

					{{-- Mouths 5–8 --}}
					<div class="mouth-list">
						@for ($i = 5; $i <= 8; $i++)
							<button
								type="button"
								class="mouth-choice js-mouth-choice"
								data-id="{{ $i }}"
								draggable="true"
								aria-label="Bocca {{ $i }}"
								aria-pressed="false"
							>
								<div class="mouth-choice-wrapper">
									<img
										src="{{ $mouthAsset($i) }}"
										alt=""
										draggable="false"
									>
								</div>
							</button>
						@endfor
					</div>

				</div>

				{{-- Submitted values --}}
				<input
					type="hidden"
					name="field[]"
					class="js-chosen-face"
				>

				<input
					type="hidden"
					name="field[]"
					class="js-chosen-mouth"
				>

				<input
					type="hidden"
					name="field[]"
					class="js-chosen-emotion"
				>

				<div class="mt-40 flex justify-center gap-4">

					<x-button
						type="button"
						variant="secondary"
						class="js-emotion-reset center-icon"
					>
						<x-icon-refresh />
						{{ __('Reset') }}
					</x-button>

					<x-button
						type="submit"
						class="js-emotion-submit"
						disabled
					>
						{{ __('Continue') }}
					</x-button>

				</div>

				@if ($errors->any())
					<div class="mt-4 text-center text-red-600">
						{{ $errors->first() }}
					</div>
				@endif

			@endif

		</form>

	</section>

</x-layouts.test>
