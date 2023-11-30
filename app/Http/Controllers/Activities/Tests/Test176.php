<?php

namespace app\Http\Controllers\Activities\Tests;

use app\Http\Controllers\Activities\Test;
use Singleton;

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
class Test176 extends Test {

	use Singleton;

	protected $retryEnabled = true;
	protected $skipEnabled = true;
	protected $buttonIsProgressive = true;
	protected $arguments = [];

	function __construct() {
		$this->arguments['correctAnswers'] = [['in volo'], ['sul ponte', 'sulla nave'], ['poeta'], ['bello', 'incurante dei pericoli', 'coraggioso'], ['incurante dei pericoli', 'coraggioso', 'bello'], ['brutto', 'impacciato', 'goffo'], ['impacciato', 'goffo', 'brutto'], ['esule', 'eremita'], ['avversità'], ['critiche']];

		$this->arguments['text'] = "Il contenuto di questa poesia si struttura su due confronti: nel primo caso si mette a contrasto l’albatro
		quando è {{ place-input }} con quando si trova {{ place-input }}, perché è stato catturato dai marinai; nel	secondo caso l’albatro viene paragonato al {{ place-input }}.<br>
		Quando l’albatro segue la nave come un “indolente compagno di viaggio” appare {{ place-input }}, padrone del cielo e {{ place-input }}. Quando invece è costretto dall’equipaggio a restare	sul ponte, appare {{ place-input }}, comico, {{ place-input }} e quasi malato.<br>
		È simile in questo al poeta, che nella vita comune viene spesso deriso, vive come un {{ place-input }}, appare goffo, mentre con la poesia diventa padrone dell’immaginazione, sfida le {{ place-input }}, non teme le {{ place-input }}.";
	}

	protected function init() {
		$this->view();

		return $this;
	}

	protected function logic() {
		// results
		$this->parameters['correctAnswers'] = $this->arguments['correctAnswers'];

		// text
		$text = $this->arguments['text'];

		function _process_text($text, $correctAnswers) {
			$text = explode('{{ place-input }}', $text);

			foreach ($text as $key => $part) {
				$element = '';

				if ($key) {
					if (test()->completed) {
						$elementClasses = ['test-answer'];
						$status = in_array(trim(strtolower(test()->rawResults[$key - 1])), $correctAnswers[$key - 1]) ? 'test-answer--right' : 'test-answer--wrong';
						array_push($elementClasses, $status);

						$element = '<span class="' . (implode(' ', $elementClasses)) . '">' . test()->rawResults[$key - 1] . '</span>';
					} else {
						$value = test()->rawResults[$key - 1] ?? '';
						$element = '<input type="text" class="test-input js-field" name="field[]" value="' . $value . '">';
					}
				}

				$text[$key] = $element . $part;
			}

			return implode('', $text);
		}

		$this->parameters['text'] = _process_text($text, $this->parameters['correctAnswers']);

		// result count
		$this->resultCount = substr_count($text, '{{ place-input }}');
	}

	/**
	 * Template
	 */
	protected function template() {
		ob_start();
?>

		<section class="grid-flow" data-spacing="700">

			<?php if (test()->completed) { ?>

				<p class=" txt-15rem fa-center">Hai inserito <strong><?= test()->percentage ?>%</strong> dei concetti corretti.</p>

			<?php } ?>

			<?php if (test()->completed || !isSupervisor()) { ?>

				<div id="text-box" class="section">

					<h1 class="fa-center txt-3rem mar-b-2 mar-t-5 fw-bold txt-upp">Riassunto</h1>

					<p id="text" class="mar-b-2 txt-1rem"><?= $this->parameters['text'] ?></p>

					<p class="clickable mar-b-2 txt-c3 fc-primary-h inlb" onclick="$('.section').toggleClass('hidden');">
						<span class="text-icon bgr-c3" <?= icon_svg('read') ?>></span>
						<span class="btn-txt">Clicca qui per rileggere il testo</span>
					</p>
				</div>

				<div id="original-box" class="section hidden">

					<h1 class="fa-center txt-3rem mar-b-2 mar-t-5 fw-bold txt-upp">Testo</h1>

					<p id="original" class="mar-b-2 txt-1rem">
						Spesso, per divertirsi, gli uomini d’equipaggio<br>
						catturano degli albatri, grandi uccelli di mare,<br>
						che seguono, indolenti compagni di viaggio,<br>
						la nave che scivola sugli abissi amari.<br><br>

						Appena li hanno deposti sul ponte,<br>
						questi re dell’azzurro, maldestri e vergognosi,<br>
						lasciano cadere miseramente le grandi ali bianche<br>
						come remi inerti trascinati ai loro fianchi.<br><br>

						Quel viaggiatore alato, com’è sgraziato e remissivo!<br>
						Lui, poco fa così bello, com’è comico e brutto!<br>
						Uno gli stuzzica il becco con la pipa,<br>
						un altro imita, zoppicando, l’infermo che volava!<br><br>

						Il Poeta è come lui, principe delle nuvole<br>
						che sfida la tempesta e se la ride dell’arciere;<br>
						fra le grida di scherno esule in terra,<br>
						le sue ali di gigante non gli permettono di camminare.
					</p>

					<p class="clickable mar-b-2 txt-c3 fc-primary-h inlb" onclick="$('.section').toggleClass('hidden');">
						<span class="text-icon bgr-c3" <?= icon_svg('navigation/back') ?>></span>
						<span class="btn-txt">Clicca qui per tornare al riassunto</span>
					</p>
				</div>

			<?php } ?>

			<?= no_results() ?>

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
			#text,
			#original {
				text-align: justify;
			}

			#text {
				line-height: 3;
			}

			#original {
				line-height: 2;
			}

			.test-input {
				display: inline-block;
				width: 15rem;
				max-width: 100%;
				color: var(--clr-tertiary-400);
				font-size: 1em;
				line-height: 2;
			}

			.test-answer {
				display: inline;
				padding: 0 1rem;
				border-bottom: 1px solid currentColor;
				font-weight: bold;

				&.test-answer--right {
					color: var(--clr-good-400);
				}

				&.test-answer--wrong {
					color: var(--clr-bad-400);
				}
			}
		</style>

<?php return ob_get_clean();
	}

	/**
	 * Post methods
	 */
	public function calcResult(array $results = [], int $count = null) {
		$rightAnswerCount = 0;
		$correctAnswers = $this->arguments['correctAnswers'];

		foreach ($results as $key => $result) {
			if (in_array(trim(strtolower($result)), $correctAnswers[$key])) {
				$rightAnswerCount++;
			}
		}

		return percent($rightAnswerCount, $count);
	}
}
