<?php

namespace Legacy\Http\Controllers\Activities\Tests;

use Legacy\Http\Controllers\Activities\Test;


/**
 * Specific test class
 * 
 * @property int $resultCount = 0 <inherited>
 * @property bool $buttonIsProgressive = false <inherited>
 * @property bool $skipEnabled = false <inherited>
 * @property bool $retryEnabled = false <inherited>
 * @property array $parameters = [] <inherited>
 * @property array $arguments = []
 */
class RuotaAvanzatoCaravaggio extends Test {

	use \System\Traits\Singleton;

	protected $skipEnabled = true;
	protected $retryEnabled = true;
	protected $buttonIsProgressive = true;
	// protected $arguments = [];

	/**
	 * Initialize
	 */
	private function __construct() {
		$this->arguments['emotions'] = [];

		for ($i = 1; $i <= 12; $i++) {
			$this->arguments['emotions'][] = __('tests.205-emotion-' . $i);
		}

		$this->arguments['correctResults'] = [
			9,
			8,
			3,
			6,
			7,
			1,
			12,
			10,
			4,
			11,
			5,
			2
		];

		$this->resultCount = count($this->arguments['correctResults']);
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
			<?php if (isSupervisor() && !test()->completed) { ?>
				<?= no_results() ?>
			<?php  } else { ?>

				<?php if (test()->completed) { ?>

					<p class="txt-15rem fa-center mb-12"><?= __('tests.205-completed', ['percentage' => test()->percentage]) ?></p>

				<?php } ?>

				<div class="paintings grid grid-column gap-8 columns-15rem">

					<?php foreach ($this->arguments['correctResults'] as $paintingKey => $paintingResult) {
						$correctAnswer = test()->completed && test()->rawResults[$paintingKey] == $this->arguments['correctResults'][$paintingKey];
					?>

						<div class="painting grid gap-4 js-painting <?= test()->completed ? ($correctAnswer ? 'painting__correct' : 'painting__wrong') : '' ?>" data-id="<?= $paintingKey + 1 ?>">
							<img class="painting__image rounded shadow-focused img-fill" src="<?= client_path('painting-' . ($paintingKey + 1)) ?>" alt="">
							<select class="painting__select js-field" name="field[]" required data-value="0" <?= test()->completed ? 'disabled' : '' ?>>

								<!-- Option -->
								<option value="0" disabled <?= !test()->completed ? 'selected' : '' ?>>Seleziona un'opzione</option>

								<?php foreach ($this->arguments['emotions'] as $emotionKey => $emotion) {
									$emotionValue = $emotionKey + 1;
									$selectedOption = test()->completed && test()->rawResults[$paintingKey] == $emotionValue;
								?>

									<option value="<?= $emotionValue ?>" <?= $selectedOption ? 'selected' : '' ?>><?= $emotion ?></option>

								<?php } ?>

							</select>
						</div>

					<?php } ?>

				</div>

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
			document.addEventListener('DOMContentLoaded', function() {
				const paintingSelector = '.js-painting'

				document.querySelectorAll(`${paintingSelector} .js-field`).forEach((element) => {
					element.addEventListener('change', (event) => {
						let id = element.closest(paintingSelector).dataset.id
						let value = element.value

						element.dataset.value = element.value

						document.querySelectorAll(`${paintingSelector}:not([data-id="${id}"]) .js-field`).forEach((selector) => {
							if (selector.value == value) {
								selector.value = 0
								selector.dataset.value = 0
							}
						})
					})
				})
			})
		</script>

	<?php return ob_get_clean();
	}

	/**
	 * Style
	 */
	protected function style() {
		ob_start();
	?>

		<style>
			.painting__image {
				aspect-ratio: 1;
				background-color: #ccc;
				position: relative;
				z-index: 1;
			}

			.painting__select {
				background-color: #fff;
				outline: 2px solid var(--color-neutral-300);
				outline-style: dashed;
				transition: outline 0.2s ease-in-out, background-color 0.2s ease-in-out, color 0.2s ease-in-out;

				&:not([data-value="0"]) {
					background-color: var(--color-secondary-400);
					outline-style: solid;
					outline-color: var(--color-secondary-400);
					color: #fff;
				}

				.painting__correct & {
					background-color: var(--color-success-400);
					outline-style: solid;
					outline-color: var(--color-success-400);
					color: #fff;
				}

				.painting__wrong & {
					background-color: var(--color-error-400);
					outline-style: solid;
					outline-color: var(--color-error-400);
					color: #fff;
				}
			}
		</style>

<?php return ob_get_clean();
	}

	/**
	 * Post methods
	 */
	public function calcResult(array $results = [], int $count = null) {
		$correctResults = $this->arguments['correctResults'];
		$rightAnswers = 0;

		foreach ($results as $key => $result) {
			if ($result == $correctResults[$key]) {
				$rightAnswers++;
			}
		}
		return percent($rightAnswers, $count);
	}
}
