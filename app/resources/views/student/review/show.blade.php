@pushOnce('styles')
	<style>
		/*
																																	* Layout
																																	*/
		.page-content {
			display: grid;
			grid-template-columns: minmax(0, 1fr);
			align-items: center;
		}

		.checkbox {
			--border-clr-400: #aaa;
		}

		/*
																																	* Header
																																	*/

		/*
																																	* Completed
																																	*/
		.completed {
			display: grid;
			align-content: center;
			justify-items: center;
			min-height: calc(100vh - 84px);
		}

		.success-icon {
			--icon-size: 70%;
			width: 6rem;
			aspect-ratio: 1;
			border: 0.5rem solid currentColor;
			border-radius: 50%;
			color: var(--color-good-400);
		}

		/* Questions */
		.question>.text {
			gap: 0.5rem;
			font-weight: 600;
			font-size: 1rem;
		}

		.question>.text .number {
			display: inline-block;
			width: max-content;
			color: var(--color-secondary-400);
			line-height: 1.3rem;
		}

		.question.question--completed>.text .number {
			display: none;
		}

		.question>.text .icon-embed {
			display: none;
			color: green;
			width: 1.5rem;
			height: 1rem;
			top: -3px;
			vertical-align: middle;
		}

		.question.question--completed>.text .icon-embed {
			display: inline-block;
		}

		.question .error-warning {
			display: none;
		}

		.review-grid {
			width: 100%;
			border: 1px solid #eee;
			border-width: 1px 0;
			margin-top: 1rem;
		}

		.grid-row {
			display: grid;
			grid-auto-flow: column;
			grid-auto-columns: minmax(0, 1fr);
			align-items: center;
			justify-items: center;
			padding-block: 0.5rem;
		}

		.grid-row--legend {
			grid-template-columns: 3fr;
		}

		.grid-row:nth-child(2n) {
			background-color: #f6f6f6;
		}

		.grid-cell {
			display: grid;
			width: 100%;
			justify-items: center;
		}

		.grid-cell--title {
			justify-content: left;
			padding-inline: 1rem;
		}

		.question .grid-text {
			font-size: 0.9rem;
		}

		.question .grid-text {
			font-size: 0.9rem;
		}

		.grid-row--head .grid-text {
			font-weight: 600;
			text-align: center;
		}

		.question .grid .cbx-box {
			margin: 0;
		}

		.question .cbx-icon {
			width: 1.2rem;
			height: 1.2rem;
		}

		.answers--list {
			display: grid;
			gap: 0.5rem;
		}

		.answers--inputs {
			display: grid;
			gap: 1rem;
		}

		/*
																																	* Specific questions
																																	*/
		#question-s2d3a,
		#question-s2d3b,
		#question-s2d3c,
		#question-s2d3d,
		#question-s6d3,
		#question-s7d3,
		#question-s7d4,
		#question-s7d5 {
			display: none;
		}
	</style>
@endpushOnce

@pushOnce('scripts')
	<script
		src="https://code.jquery.com/jquery-3.7.1.min.js"
		integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo="
		crossorigin="anonymous"
	></script>

	<script defer>
		document.addEventListener('DOMContentLoaded', () => {
			const toggableRadioButtons = document.querySelectorAll('main input[type="radio"]');

			toggableRadioButtons.forEach((radioButton) => {
				radioButton.addEventListener('click', function() {
					if (this.previous) {
						this.checked = false;
					}

					toggableRadioButtons.forEach((btn) => (btn.previous = false));
					this.previous = this.checked;

					completed_question(this.closest('.js-question'));
				});
			});

			function completed_question(question) {
				const multiple = question.dataset.multiple === "1";

				let completed = true;

				if (multiple) {
					if (!question.querySelectorAll('.js-cbx:checked').length) {
						completed = false;
					}
				} else {
					const checkboxes = question.querySelectorAll('.js-cbx');
					checkboxes.forEach((checkbox) => {
						const name = checkbox.name;
						if (!question.querySelector(`.js-cbx[name="${name}"]:checked`)) {
							completed = false;
						}
					});
				}

				if (completed) {
					question.dataset.completed = "1";
					question.classList.add('question--completed');
					const errorWarning = question.querySelector('.js-error-warning');
					if (errorWarning) {
						errorWarning.style.display = "none";
					}
				} else {
					question.dataset.completed = "0";
					question.classList.remove('question--completed');
				}
			}
		})

		$(document).ready(function() {
			/*
			 * Checkbox change
			 */
			$('.js-cbx').on('change', function() {
				const self = $(this)
				const name = self.attr('name')
				const question = self.parents('.js-question')

				$('.js-cbx[name="' + name + '"]').prop('checked', false)
				self.prop('checked', true)

				completed_question(question)
			})

			/*
			 * Input change
			 */
			$('.js-input').on('keyup', function() {
				const self = $(this)
				const question = self.parents('.js-question')

				if (self.val()) {
					completed_question(question)
				}
			})

			/*
			 * Complete a question
			 */
			function completed_question(question) {
				const multiple = question.data('multiple')

				let completed = true

				if (multiple) {
					if (!question.find('.js-cbx:checked').length) {
						completed = false
					}
				} else {
					question.find('.js-cbx').each(function() {
						const name = $(this).attr('name')

						if (!question.find('.js-cbx[name="' + name + '"]:checked').length) {
							completed = false
						}
					})
				}

				if (completed) {
					question.data('completed', 1).addClass('question--completed')
					question.find('.js-error-warning').hide()
				} else {
					question.data('completed', 0).removeClass('question--completed')
				}
			}

			/*
			 * Check overall completition
			 */
			$('.js-attempt-submit').click(function() {
				let completed = true
				let missedQuestiondId

				$('.question').each(function() {
					if (!$(this).data('completed') && !$(this).data('optional')) {
						completed = false
						missedQuestiondId = $(this).attr('id')
						return false
					}
				})

				if (completed) {
					$('.js-submit').click()
				} else {
					const missedQuestion = $('#' + missedQuestiondId)

					missedQuestion.find('.js-error-warning').show()

					$('html, body').animate({
							scrollTop: missedQuestion.offset().top,
						},
						500
					)
				}
			})

			/*
			 * Dependent questions
			 */
			$('#question-s2d2 .js-cbx').on('change', function() {
				const parsing = ['3a', '3b', '3c', '3d']
				const id = $(this).attr('name').split('_')[1]
				const questionSlug = 's2d' + parsing[id - 1]

				if ($(this).val() > 1) {
					$('#question-' + questionSlug)
						.show()
						.data('optional', 0)
				} else {
					$('#question-' + questionSlug)
						.hide()
						.data('optional', 1)
						.data('completed', 0)
						.removeClass('question--completed')
						.find('.js-cbx')
						.prop('checked', false)
				}
			})

			$('#question-s6d2 .js-cbx').on('change', function() {
				if ($(this).val() > 1) {
					$('#question-s6d3').show().data('optional', 0)
				} else {
					$('#question-s6d3').hide().data('optional', 1).data('completed', 0).removeClass(
						'question--completed').find('.js-cbx').prop('checked', false)
				}
			})

			$('#question-s7d2 .js-cbx').on('change', function() {
				if ($(this).val() == 1) {
					$('#question-s7d3').show().data('optional', 0)
				} else {
					$('#question-s7d3').hide().data('optional', 1).data('completed', 0).removeClass(
						'question--completed').find('.js-cbx').prop('checked', false)
				}

				if ($(this).val() == 2) {
					$('#question-s7d4').show().data('optional', 0)
					$('#question-s7d5').show().data('optional', 0)
				} else {
					$('#question-s7d4').hide().data('optional', 1).data('completed', 0).removeClass(
						'question--completed').find('.js-cbx').prop('checked', false)
					$('#question-s7d5').hide().data('optional', 1).data('completed', 0).removeClass(
						'question--completed').find('.js-cbx').prop('checked', false)
				}
			})
		})
	</script>
@endpushOnce

<x-layouts.legacy-main>

	<form
		class="page-content main-wrap"
		method="POST"
		action="{{ route('review.store', $review) }}"
	>
		@csrf

		<input
			type="hidden"
			name="review_id"
			value="{{ $review->id }}"
		>

		<?php if ($legacyReview->completed) { ?>

		<div class="grid content-center justify-items-center gap-8 py-20 text-center">
			<div class="success-icon grid place-items-center">
				<x-icon-correct class="w-2/3" />
			</div>

			<x-heading.main>Grazie per aver<br>completato il formulario</x-heading.main>

			<x-subheading.main>Le tue risposte sono state salvate. Puoi cliccare qui sotto per continuare con le
				attività
				proposte</x-subheading.main>

			<x-button
				href="{{ route('home') }}"
				variant="secondary"
			>Continua le attività</x-button>
		</div>

		<?php } else { ?>

		<div class="header pad-t-7">
			<h1 class="txt-3rem fa-center txt-sbold"><?= $legacyReview->title ?></h1>
			<p class="txt-12rem fa-center mar-t-2"><?= $legacyReview->description ?></p>
		</div>

		<!-- Questions -->
		<div class="questions pad-b-5">

			<?php

			$i = 0;

			foreach ($legacyReview->areas as $area) { ?>

			<section class="section mar-b-4 mar-t-5">
				<p class="stitle txt-c3 txt-15rem txt-sbold"><?= $area->title ?></p>

				<?php if ($area->text) { ?>
				<p><?= $area->text ?></p>
				<?php } ?>

				<?php foreach ($area->getQuestions($legacyReview->id) as $key => $question) {
						$i++;
					?>

				<!-- Question -->
				<div
					id="question-<?= $question->fullSlug ?>"
					class="question <?= $question->type ? 'mar-b-3' : '' ?> js-question"
					data-optional="<?= $question->optional ?>"
					data-completed="0"
					data-multiple="<?= $question->multiple ?>"
				>

					<p class="text mar-t-2">
						<?= $debugger ? '(' . $question->fullSlug . ')' : '' ?>
						<?php if ($question->text) { ?>

						<?= embed_icon('correct') ?>
						<span class="number"><?= $i ?>.</span> <?= $question->text ?>

						<?php } ?>
					</p>

					<p class="error-warning js-error-warning">Devi rispondere a tutte le domande prima di poter continuare.</p>

					<?php switch ($question->type) {
								case 'grid': { ?>

					<!-- Grid -->
					<div class="review-grid js-grid">

						<!-- Head -->
						<div class="grid-row grid-row--head <?= $question->hasLegend ? 'grid-row--legend' : '' ?>">

							<?php if ($question->hasLegend) { ?>

							<span></span>

							<?php } ?>

							<?php foreach ($question->gridHeader as $content) { ?>

							<p class="grid-text"><?= $content ?></p>

							<?php } ?>

						</div>

						<!-- Rows -->
						<?php foreach ($question->rows as $row) { ?>

						<!-- Row -->
						<div class="grid-row js-grid-row <?= $question->hasLegend ? 'grid-row--legend' : '' ?>">

							<?php if (isset($row['title'])) { ?>

							<p class="grid-cell grid-cell--title"><?= $row['title'] ?></p>

							<?php } ?>

							<!-- Cells -->
							<?php foreach ($row['content'] as $cell) { ?>

							<div class="grid-cell">

								<label class="checkbox">
									<input
										type="radio"
										class="field js-cbx"
										name="<?= $cell['name'] ?>"
										value="<?= $cell['value'] ?>"
										data-type="row"
									>

									<span></span>
								</label>

								<?php if ($debugger) { ?>
								<p><?= $cell['name'] . ' = ' . $cell['value'] ?></p>
								<?php } ?>

							</div>


							<?php } ?>

						</div>

						<?php } ?>

					</div>

					<?php }
									break;

								case 'list': { ?>

					<div class="answers answers--list mt-2">

						<?php foreach ($question->rows as $row) { ?>

						<label class="checkbox">
							<input
								type="radio"
								name="<?= $row['name'] ?>"
								value="<?= $row['value'] ?>"
								class="field js-cbx"
							>

							<span></span>

							<p class="">
								<?= $row['title'] ?>
								<?= $debugger ? '<strong>(' . $row['name'] . ' = ' . $row['value'] . ')</strong>' : '' ?>
							</p>
						</label>

						<?php } ?>

					</div>

					<?php }
									break;

								case 'number': { ?>
					<input
						type="number"
						class="field js-input mar-t-1"
						name="<?= $question->fullSlug ?>"
						min="1"
						max="100"
						placeholder="Numero"
						required
					>

					<?php }
							} ?>

				</div>

				<?php } ?>

			</section>

			<?php } ?>

			<div class="fa-center mar-t-3">
				<button
					type="submit"
					id="submit"
					class="js-submit hidden"
				></button>
				<x-button
					type="button"
					class="js-attempt-submit"
				>Invia</x-button>
			</div>

		</div>

		<?php } ?>

	</form>

</x-layouts.legacy-main>
