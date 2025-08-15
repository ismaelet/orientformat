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
class Test196 extends Test {

	use \System\Traits\Singleton;

	// protected $skipEnabled = true;
	protected $retryEnabled = true;
	protected $buttonIsProgressive = true;
	protected $arguments = [];

	/**
	 * Initialize
	 */
	private function __construct() {
		$this->arguments['text'] = "In questa città c’era una volta (e forse c’è ancora) una stradina con pochi negozi bui e odorosi{{ selector }} un magro ciabattino di tanto in tanto usciva sulla soglia della sua bottega a guardare i nuvoloni grigi che si avvolgevano e svolgevano nel cielo{{ selector }} un panciuto venditore di pane{{ selector }} latte{{ selector }} spezie e candele accorreva grassoccio e premuroso al trillo del campanello che accompagnava l’entrata dei clienti.<br> 
		E poi c’era un giocattolaio{{ selector }} l’eroe della nostra storia. Era un ometto piccolo{{ selector }} curvato dagli anni{{ selector }} con le mani fini e inquiete{{ selector }} gli occhi stellanti.";

		$this->arguments['correctAnswers'] = [
			3,
			4,
			1,
			1,
			1,
			1,
			1,
			1
		];
	}

	protected function init() {
		$this->view();

		return $this;
	}

	protected function logic() {

		$text = $this->arguments['text'];

		function _generate_text($text, $correctAnswers) {
			$punctuations = [
				1 => ',',
				2 => '.',
				3 => ':',
				4 => ';',
				5 => '...',
				6 => '!',
				7 => '?',
			];

			// options
			$count = substr_count($text, '{{ selector }}');
			$selectors = [];

			for ($i = 1; $i <= $count; $i++) {
				// $correctAnswer = $correctAnswers[$i - 1];
				$options = !test()->completed ? ['<option value="0" disabled selected></option>'] : [];

				foreach ($punctuations as $punctcuationKey => $punctcuation) {
					$result = test()->rawResults[$i - 1] ?? null;
					$selected = $result && $result == $punctcuationKey;
					$options[] = '<option value="' . $punctcuationKey . '" ' . ($selected ? 'selected' : null) . '>' . $punctcuation . '</option>';
				}

				$selectors[] = implode(PHP_EOL, $options);
			}

			// sentences
			$selectorKey = 0;
			$textHtml = $text;
			$placeholder = '{{ selector }}';

			while (strpos($textHtml, $placeholder) !== false) {
				$correctResult = test()->completed && (test()->rawResults[$selectorKey] ?? null) == $correctAnswers[$selectorKey];

				$selector = $selectors[$selectorKey];
				$selectorHtml = '<select class="js-field ' . (test()->completed ? ($correctResult ? 'right' : 'wrong') : null) . '" name="field[]" ' . (test()->completed || isSupervisor() ? 'disabled' : '') . '>' . $selector . '</select>';
				$position = strpos($textHtml, $placeholder);
				$textHtml = substr_replace($textHtml, $selectorHtml, $position, strlen($placeholder));

				$selectorKey++;
			}

			return $textHtml;
		}

		$this->parameters['text'] = _generate_text($text, $this->arguments['correctAnswers']);
		$this->resultCount = count($this->arguments['correctAnswers']);
	}

	/**
	 * Template
	 */
	protected function template() {
		ob_start();
?>

		<section class="grid" data-spacing="700">
			<?php if (test()->completed) { ?>

				<p class="txt-15rem fa-center">Hai inserito il <strong><?= test()->percentage ?>%</strong> dei segni di punteggiatura corretti.</p>

			<?php } ?>

			<div class="text grid" data-spacing="700">

				<p class="text"><?= $this->parameters['text'] ?></p>

			</div>
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
			.text {
				font-size: var(--fs-450);
				line-height: 2.5;
			}

			.text select {
				width: 2.5rem;
				height: 1.5em;
				padding-inline: 0;
				opacity: 1;
				line-height: 1.5;
				font-size: var(--fs-500);
				cursor: pointer;

				&.right {
					color: var(--color-good-400);
					cursor: default;
				}

				&.wrong {
					color: var(--color-bad-400);
					cursor: default;
				}
			}

			.result {
				font-size: var(--fs-450);
				text-align: center;

				& span {
					font-weight: var(--font-bold);
				}
			}
		</style>

<?php return ob_get_clean();
	}

	/**
	 * Post methods
	 */
	public function calcResult(array $results = [], int $count = null) {
		$correctAnswerCount = 0;
		$correctAnswers = $this->arguments['correctAnswers'];

		foreach ($results as $answerKey => $answer) {
			if ($answer == $correctAnswers[$answerKey]) {
				$correctAnswerCount++;
			}
		}

		return percent($correctAnswerCount, $count);
	}
}
