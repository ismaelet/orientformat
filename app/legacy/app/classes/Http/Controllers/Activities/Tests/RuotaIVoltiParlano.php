<?php

namespace Legacy\Http\Controllers\Activities\Tests;

use Legacy\Http\Controllers\Activities\Test;


/**
 * Specific test class
 */
class RuotaIVoltiParlano extends Test {

	use \System\Traits\Singleton;

	// protected $skipEnabled = true;
	protected $resultCount = 3;
	protected $buttonIsProgressive = true;
	// protected $retryEnabled = true;
	// protected $arguments = [];

	/**
	 * Initialize
	 */
	private function __construct() {
	}

	protected function init() {
		$this->view();

		return $this;
	}

	/**
	 * Logic
	 */
	protected function logic() {
		// $this->parameters['content'] = null;
		// $this->resultCount = 0;
	}

	/**
	 * Template
	 */
	protected function template() {
		ob_start();
?>

		<section>

			<?php if (isSupervisor() && !legacy_test()->completed) { ?>
				<?= no_results() ?>
			<?php  } else { ?>

				<?php if (legacy_test()->completed) {
					$faceId = legacy_test()->rawResults[0];
					$mouthId = legacy_test()->rawResults[1];
					$emotion = legacy_test()->rawResults[2] ?? '';
				?>

					<div class="grid justify-items-center gap-8">
						<p class="text-xl text-center font-bold"><?= __('You have chosen the following emotion:') ?></p>

						<div class="face max-w-64">
							<img class="eye" src="<?= public_asset('test-volti/eye-' . $faceId . '.png') ?>" alt="">
							<img src=" <?= public_asset('test-volti/mouth-' . $mouthId . '.png') ?>" alt="" class="mouth">
						</div>

						<p class="text-center font-semibold text-lg text-success"><?= $emotion ?></p>

						<?php if (!isSupervisor()) { ?>
							<button class="button button--secondary button--auto-width" name="redo" value="<?= legacy_test()->id ?>"><?= __('Choose another emotion') ?></button>
						<?php } ?>
					</div>


				<?php } else { ?>

					<div class="mobile-wrapper">
						<div class="page-wrapper non-completed-test">

							<div class="mouth-list js-mouth-list">
								<?php for ($i = 1; $i <= 4; $i++) { ?>
									<div class="face face--only-mouth js-mouth" data-id="<?= $i ?>">
										<img src=" <?= public_asset('test-volti/mouth-' . $i . '.png') ?>" alt="" class="mouth">
									</div>
								<?php } ?>
							</div>

							<div class="circle">
								<p class="test-descrition">
									<?= test_description() ?>
								</p>

								<?php for ($i = 1; $i <= 8; $i++) { ?>

									<div class="emotion" style="--i: <?= $i ?>;" data-id="<?= $i ?>">
										<div class="face stack-content js-face">
											<img class="eye" src="<?= public_asset('test-volti/eye-' . $i . '.png') ?>" alt="">
											<img class="mouth" src="" alt="">
										</div>

										<div class="flex emotion-label-wrapper gap-2 items-center flex-nowrap">
											<input type="text" class="emotion-label js-emotion-label" placeholder="<?= __('Emotion') ?>" maxlength="18">

											<button type="button" class="w-4 flex-0 js-reset reset">
												<?= embed_icon('close') ?>
											</button>
										</div>
									</div>

								<?php } ?>
							</div>

							<div class="mouth-list">
								<?php for ($i = 5; $i <= 8; $i++) { ?>
									<div class="face face--only-mouth js-mouth" data-id="<?= $i ?>">
										<img src="<?= public_asset('test-volti/mouth-' . $i . '.png') ?>" alt="" class="mouth">
									</div>
								<?php } ?>
							</div>
						</div>
					</div>

					<input type="hidden" name="field[]" class="js-chosen-face js-field">
					<input type="hidden" name="field[]" class="js-chosen-mouth js-field">
					<input type="hidden" name="field[]" class="js-chosen-emotion js-field">

				<?php } ?>
			<?php } ?>

		</section>

	<?php return ob_get_clean();
	}

	/**
	 * Scripts
	 */
	protected function scripts() {
		ob_start();
	?>

		<script defer>
			const mouthSelector = '.js-mouth';

			document.addEventListener('DOMContentLoaded', function() {
				const faces = document.querySelectorAll('.js-face');
				const chosenFace = document.querySelector('.js-chosen-face');
				const chosenMouth = document.querySelector('.js-chosen-mouth');
				const chosenEmotion = document.querySelector('.js-chosen-emotion');
				const emotionLabels = document.querySelectorAll('.js-emotion-label');
				const resetButtons = document.querySelectorAll('.js-reset');

				$(mouthSelector).draggable({
					revert: function(event, ui) {
						if (!event) {
							$(this).animate({
								top: '0px',
								left: '0px'
							}, 100)
						}
					},
				})

				$('.js-face').droppable({
					accept: mouthSelector,

					drop: function(event, ui) {
						const face = $(this)[0];
						const emotion = face.parentElement;
						const emotionInput = emotion.querySelector('.js-field');
						const selectedMouth = ui.draggable[0]
						const selectedMouthSrc = selectedMouth.querySelector('.mouth').src;
						const faceMouth = face.querySelector('.mouth');
						const mouthId = parseInt(selectedMouth.dataset.id);
						const faceId = parseInt(emotion.dataset.id);

						reset_emotions();

						selectedMouth.classList.add('disabled');

						face.classList.add('active');

						faceMouth.src = selectedMouth.querySelector('.mouth').src;

						chosenFace.value = faceId;
						chosenMouth.value = mouthId;
						chosenFace.dispatchEvent(new Event('change'));
						chosenMouth.dispatchEvent(new Event('change'));
					}
				})

				emotionLabels.forEach(label => {
					label.addEventListener('input', function() {
						chosenEmotion.value = this.value;
						chosenEmotion.dispatchEvent(new Event('change'));
					})
				})

				resetButtons.forEach(button => {
					button.addEventListener('click', function() {
						reset_emotions();
					})
				})

				function reset_emotions() {
					faces.forEach(face => {
						face.classList.remove('active');
						face.querySelector('.mouth').src = '';
					})

					document.querySelectorAll(mouthSelector).forEach(mouth => {
						mouth.style.top = '0px';
						mouth.style.left = '0px';
						mouth.classList.remove('disabled');
					})

					emotionLabels.forEach(label => {
						label.value = '';
					})

					chosenFace.value = '';
					chosenMouth.value = '';
					chosenEmotion.value = '';
					chosenFace.dispatchEvent(new Event('change'));
					chosenMouth.dispatchEvent(new Event('change'));
					chosenEmotion.dispatchEvent(new Event('change'));
				}
			})
		</script>

		<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

	<?php return ob_get_clean();
	}

	/**
	 * Style
	 */
	protected function style() {
		ob_start();
	?>

		<style>
			.main-wrap {
				--face-width: clamp(5rem, 10vw, 12rem);
				--wrap-outer-width: 1600px;
			}

			.title__wrapper,
			.test-descrition {
				text-align: center;
			}

			main:has(.non-completed-test) .test__title-block .test__description {
				display: none;
			}

			main:has(.non-completed-test) .test-descrition {
				max-width: calc(100% - var(--face-width) * 4/3);
				font-size: clamp(.8rem, 2vw, 1.25rem);
				font-weight: 500;
				line-height: 1.8;
			}

			.mobile-wrapper {
				overflow-x: auto;
				padding-inline: 2rem;
				padding-block: 2rem;
			}

			@media (min-width: 1024px) {
				.mobile-wrapper {
					overflow-x: unset;
					padding-inline: 0;
					padding-block: 0;
				}
			}

			.page-wrapper {
				display: grid;
				grid-template-columns: var(--face-width) minmax(0, 1fr) var(--face-width);
				gap: calc(var(--face-width) / 2);
				min-width: 600px;
			}

			.mouth-list {
				display: grid;
				grid-template-columns: minmax(0, 1fr);
				align-content: center;
				gap: 2rem;
			}

			.circle {
				display: grid;
				grid-template-rows: minmax(0, 1fr);
				justify-items: center;
				align-items: center;
				position: relative;
				max-width: 800px;
				max-height: 800px;
				aspect-ratio: 1;
				margin-block: 7rem;
				margin-inline: auto;
				border: 2px dashed var(--color-tertiary-400);
				border-radius: 50%;
				text-align: center;
			}

			.emotion {
				--angle: calc((var(--i) - 1) * 45deg);
				--x: calc(50% - cos(var(--angle)) * 50%);
				--y: calc(50% - sin(var(--angle)) * 50%);
				position: absolute;
				left: var(--x);
				bottom: var(--y);
				width: var(--face-width);
				translate: -50% 50%;
			}

			.face {
				display: grid;
				grid-template-columns: minmax(0, 1fr);
				overflow: hidden;
				aspect-ratio: 1;
				padding: .8rem;
				background-color: var(--color-background);
				border-radius: 50%;
				box-shadow: 0 0 2rem 0 hsl(0deg 0% 0% / .15);

				img {
					user-select: none;
				}
			}

			.face--only-mouth {
				background-color: transparent;
				position: relative;
				z-index: 10;
				cursor: pointer;
				mix-blend-mode: multiply;

				&::before {
					content: '';
					position: absolute;
					bottom: 0;
					left: 0;
					right: 0;
					height: 50%;
					background-color: var(--color-background);
				}

				img {
					position: relative;
					z-index: 1;
				}
			}

			.face--only-mouth.disabled {
				pointer-events: none;
				opacity: .3;
			}

			.eye {
				pointer-events: none;
			}

			.mouth {
				mix-blend-mode: multiply;
			}

			.mouth {
				align-self: flex-end;
			}

			.emotion-label-wrapper {
				margin-top: 1rem;
				opacity: 0;
				visibility: hidden;
				transition: opacity .3s, visibility .3s;

			}

			.active~.emotion-label-wrapper {
				opacity: 1;
				visibility: visible;
				transition: opacity .3s;
			}

			.emotion-label {
				padding: 0 .5em;
				background-color: #fff;
				border: 1px solid var(--color-tertiary-400);
				color: #222;
				line-height: 2;
				font-size: 1rem;
				text-align: center;
			}

			.reset {
				--icon-size: 1rem;
				background-color: transparent;
			}
		</style>

<?php return ob_get_clean();
	}

	/**
	 * Post methods
	 */
	public function calcResult(array $results = [], int $count = null) {
		return 100;
	}
}
