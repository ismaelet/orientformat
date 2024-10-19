<?php

namespace app\Http\Controllers\Activities\Tests;

use app\Http\Controllers\Activities\Test;


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
class RuotaIVoltiParlano extends Test {

	use \System\Traits\Singleton;

	protected $skipEnabled = true;
	protected $resultCount = 8;
	// protected $retryEnabled = true;
	// protected $buttonIsProgressive = true;
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

			<?php if (isSupervisor() && !test()->completed) { ?>
				<?= no_results() ?>
			<?php  } else { ?>

				<?php if (test()->completed) { ?>

				<?php } ?>

				<div class="circle">
					<p class="test-descrition">
						<?= test_description() ?>
					</p>

					<?php for ($i = 0; $i < 8; $i++) { ?>

						<div class="emotion" style="--i: <?= $i ?>;">
							<div class="face">
								<img class="eye" src="<?= public_asset('test-volti/eye-' . ($i + 1) . '.png') ?>" alt="">
								<img class="eye" src="<?= public_asset('test-volti/mouth-' . ($i + 1) . '.png') ?>" alt="">
							</div>

							<input type="text" name="field[]" class="emotion-label js-field" placeholder="Emozione">
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
			.test__title-block .test__description {
				display: none;
			}

			.test-descrition {
				max-width: calc(100% - 16rem);
				font-size: 1.25rem;
				font-weight: 500;
				line-height: 1.8;
			}

			.circle {
				display: grid;
				grid-template-rows: minmax(0, 1fr);
				justify-items: center;
				align-items: center;
				position: relative;
				max-width: 800px;
				aspect-ratio: 1;
				margin-block: 7rem;
				margin-inline: auto;
				border: 2px dashed var(--color-tertiary-400);
				border-radius: 50%;
				text-align: center;
			}

			.emotion {
				--angle: calc(var(--i) * 45deg);
				--x: calc(50% - cos(var(--angle)) * 50%);
				--y: calc(50% - sin(var(--angle)) * 50%);
				position: absolute;
				left: var(--x);
				bottom: var(--y);
				width: 12rem;
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
				box-shadow: 0 0 2rem 0 hsl(var(--color-tertiary-400-hsl) / .15);
			}

			.eye {}

			.emotion-label {
				margin-top: 1rem;
				padding: .4rem .5rem;
				background-color: #fff;
				border: 1px solid var(--color-tertiary-400);
				color: #222;
				font-weight: 500;
				text-align: center;
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
