@pushOnce('styles')
	<style>
		:root {
			--wrap-width: 1440px;
		}

		main {
			overflow: hidden;
		}

		.background {
			overflow: hidden;
			position: absolute;
			inset: 0;
		}

		#body {
			display: grid;
			grid-template-rows: minmax(0, 1fr) max-content;
			min-height: 100%;
		}

		.page-wrapper {
			height: 100%;
			padding-block: min(5rem, 20vw);
		}

		.questions-carousel {
			--_pos: 1;
			display: grid;
			grid-template-columns: minmax(0, 1fr);
			align-items: center;
		}

		.questions-wrapper {
			display: grid;
			grid-auto-flow: column;
			grid-auto-columns: 100%;
			align-items: center;
			transform: translateX(calc(-100% * (var(--_pos) - 1)));
			transition: transform 0.6s;
		}

		.question {
			overflow: hidden;
			opacity: 0;
			pointer-events: none;
			transition: opacity 0.3s;
		}

		.question.active {
			opacity: 1;
			pointer-events: all;
			transition: opacity 0.5s 0.1s ease-in;
		}

		.sec-title {
			opacity: 0.1;
			font-size: clamp(100px, 15vw, 220px);
			transition-delay: 0.3s;
			opacity: 0.03;
			color: var(--color-tertiary-400);
		}

		.section-subtitle {
			margin-bottom: 0.5em;
			color: var(--color-tertiary-400);
			font-size: min(var(--text-lg), 6vw);
			letter-spacing: min(0.3em, 1.5vw);
		}

		.question-text {
			font-size: min(var(--text-5xl), 9vw);
		}

		.title span {
			display: inline-block;
			margin: 1rem 0;
		}

		.answers {
			display: grid;
			grid-auto-flow: column;
			grid-auto-columns: minmax(0, 1fr);
			gap: 1rem;
			margin-top: min(5rem, 15vw);
			justify-content: space-around;
			text-align: center;
		}

		.answer {
			display: grid;
			align-content: flex-start;
			justify-items: center;
			gap: 2rem;
			color: var(--_color);
		}

		.answer:nth-child(1) {
			--_color: var(--color-1-of-5);
		}

		.answer:nth-child(2) {
			--_color: var(--color-2-of-5);
		}

		.answer:nth-child(3) {
			--_color: var(--color-3-of-5);
		}

		.answer:nth-child(4) {
			--_color: var(--color-4-of-5);
		}

		.answer:nth-child(5) {
			--_color: var(--color-5-of-5);
		}

		.answer-icon {
			display: flex;
			width: min(3.5rem, 13vw);
			aspect-ratio: 1;
			border-width: 4px;
			border-style: solid;
			border-color: var(--_color);
			border-radius: 50%;
			cursor: pointer;
		}

		.answer-dot {
			width: 1rem;
			aspect-ratio: 1;
			margin: auto;
			opacity: 0;
			background-color: var(--_color);
			border-radius: 100%;
			transition: opacity 0.3s;
		}

		.answer-cbx:checked+.answer-dot,
		.answer-icon:hover .answer-dot {
			opacity: 1;
		}

		.answer-text {
			max-width: 5rem;
		}

		@media (max-width: 480px) {
			.answers {
				display: grid;
				grid-auto-flow: row;
				grid-auto-columns: minmax(0, 1fr);
				gap: 0.5rem;
				justify-items: left;
				justify-content: space-around;
				text-align: left;
			}

			.answer {
				grid-template-columns: max-content 1fr;
				align-items: center;
			}

			.answer-icon {
				border-width: 3px;
			}

			.answer-text {
				max-width: unset;
			}
		}

		#slide-arrow-box {
			display: flex;
			justify-content: space-between;
			height: 5rem;
		}

		.slide-arrow {
			display: flex;
			align-items: center;
			justify-content: center;
			gap: 1rem;
			width: 15rem;
			max-width: 50%;
			height: 100%;
			opacity: 1;
			background-color: var(--color-tertiary-400);
			letter-spacing: 0.1em;
			cursor: pointer;
			transition: opacity 0.2s;
		}

		.slide-arrow.disabled {
			opacity: 0;
			pointer-events: none;
		}

		.slide-arrow-text {
			color: #fff;
		}

		.slide-arrow-icon {
			width: 1.5rem;
			transition: transform 0.4s;
		}

		.slide-arrow-icon svg {
			fill: #fff;
		}

		.slide-arrow[data-direction='left']:hover .slide-arrow-icon {
			transform: translateX(-0.5rem);
		}

		.slide-arrow[data-direction='right']:hover .slide-arrow-icon {
			transform: translateX(0.5rem);
		}
	</style>
@endpushOnce

@pushOnce('scripts')
	<script defer>
		document.addEventListener('DOMContentLoaded', () => {
			const carousel = document.querySelector('.questions-carousel');

			checkArrows();

			document.querySelectorAll('.answer-cbx').forEach((checkbox) => {
				checkbox.addEventListener('change', function() {
					const pos = Number(carousel.dataset.pos) + 1;
					const question = this.closest('.question');

					question.querySelectorAll('.answer-cbx').forEach((cbx) => {
						cbx.checked = false;
					});

					this.checked = true;

					carouselSlide(pos);
				});
			});

			document.querySelectorAll('.slide-arrow').forEach((arrow) => {
				arrow.addEventListener('click', function() {
					const direction = this.dataset.direction;

					let pos = Number(carousel.dataset.pos);

					if (direction === 'right') {
						pos++;
					} else {
						pos--;
					}

					carouselSlide(pos);
				});
			});

			function checkArrows() {
				const leftArrow = document.querySelector('.slide-arrow[data-direction="left"]');
				const rightArrow = document.querySelector('.slide-arrow[data-direction="right"]');
				const pos = Number(carousel.dataset.pos);
				const count = document.querySelectorAll('.question').length;
				const currentQuestion = document.querySelector(`.question:nth-child(${pos})`);
				const checked = currentQuestion?.querySelectorAll('.answer-cbx:checked').length ?? 0;

				if (checked && pos < count) {
					rightArrow.classList.remove('disabled');
				} else {
					rightArrow.classList.add('disabled');
				}

				if (pos > 1) {
					leftArrow.classList.remove('disabled');
				} else {
					leftArrow.classList.add('disabled');
				}
			}

			function carouselSlide(pos) {
				const questions = document.querySelectorAll('.question');
				const count = questions.length;

				if (pos <= count) {
					questions.forEach((question) => {
						question.classList.remove('active');
					});

					const question = document.querySelector(`.question:nth-child(${pos})`);

					if (question) {
						question.classList.add('active');
					}

					carousel.dataset.pos = pos;
					carousel.style.setProperty('--_pos', pos);

					checkArrows();
				} else {
					document.querySelector('#body').submit();
				}
			}

			// Timer
			let time = 0;

			window.setInterval(() => {
				time++;

				document.querySelector('#time-passed').value = time;
			}, 1000);
		});
	</script>
@endpushOnce

<x-layouts.main :$title>
	<div class="full-width relative">
		<div class="background fill-width grid items-center">
			<div class="fade-in-right">
				<h3 class="sec-title -translate-y-8 text-center uppercase">{{ $test->section->name }}</h3>
			</div>
		</div>

		<form
			id="body"
			class="full-width relative"
			method="POST"
			action="{{ route('test.store', $test) }}"
		>
			@csrf

			<div class="page-wrapper breakout grid items-center">

				<input
					type="hidden"
					id="time-passed"
					name="speed"
					value="0"
				>

				<!-- Questions -->
				<div
					class="questions-carousel"
					data-pos="1"
				>
					<div class="questions-wrapper">
						@foreach ($survey->questions as $key => $question)
							<div class="question {{ $key ? '' : 'active' }}">

								<!-- Title -->
								<h2 class="section-subtitle fade-in-bottom delay-200">
									{{ $test->title }}
									<span>{{ sprintf('%02d', $key + 1) . '/' . sprintf('%02d', $survey->questionCount()) }}</span>
								</h2>

								<h3 class="question-text section-title colored-title fade-in-top text-tertiary-400 font-semibold leading-none">
									{{ $question->text }}:</h3>

								<!-- Questions -->
								<div
									class="answers"
									data-direction="bottom"
								>
									@foreach ($survey->answers as $j => $answer)
										<div @class([
											'answer fade-in-top',
											'animation-delay-100' => $j === 0,
											'animation-delay-200' => $j === 1,
											'animation-delay-300' => $j === 2,
											'animation-delay-400' => $j === 3,
											'animation-delay-500' => $j === 4,
										])>
											<label class="answer-icon">
												<input
													type="checkbox"
													class="answer-cbx hidden"
													name="field[]"
													value="{{ $question->positive ? $j : $survey->answerCount() - 1 - $j }}"
												>
												<div class="answer-dot"></div>
											</label>

											<p class="answer-text">{{ $answer }}</p>
										</div>
									@endforeach

								</div>
							</div>
						@endforeach

					</div>
				</div>
			</div>

			<!-- Navigation arrows -->
			<div
				id="slide-arrow-box"
				class="full-width"
			>
				<div
					class="slide-arrow disabled"
					data-direction="left"
				>
					<div class="slide-arrow-icon icon-box">
						<x-icon-navigation.arrow2-left />
					</div>

					<p class="slide-arrow-text">{{ __('Previous') }}</p>
				</div>

				<div
					class="slide-arrow disabled"
					data-direction="right"
				>
					<p class="slide-arrow-text">{{ __('Next') }}</p>

					<div class="slide-arrow-icon icon-box">
						<x-icon-navigation.arrow2-right />
					</div>
				</div>
			</div>
		</form>
	</div>
</x-layouts.main>
