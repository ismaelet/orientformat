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
class Test149 extends Test {

	use \System\Traits\Singleton;

	/**
	 * Test paramenters
	 */
	// protected $skipEnabled = true;
	protected $retryEnabled = true;
	protected $buttonIsProgressive = true;
	protected $arguments = [];

	protected function init() {
		$this->view();

		return $this;
	}

	protected function logic() {
		// basic text
		$text = $this->arguments['text'] ??
			"Balene concertiste, elefanti stornellatori, scimmie polifoniche, e perfino pappagalli che suonano le percussioni. Sono alcuni dei molti esempi di animali \"musicisti\" riportati in un articolo pubblicato {! sulla rivista scientifica 'Science' :: marker1 !}, secondo cui {! amare la musica e saperla creare ed eseguire non è un'esclusiva di noi superiori esseri umani, ma un'espressione naturale, innata in molte altre specie animali. :: marker2 !} I cui gorgheggi, trilli e vocalizzi non sarebbero affatto casuali e incoerenti, ma {! insiemi sonori da giudicare musicali in senso proprio, poiché rispondono alle medesime scelte estetiche e addirittura alle stesse leggi compositive utilizzate dai musicisti umani. :: marker2 !}<br> Firmato da un agguerrito gruppetto di studiosi guidati da Patricia M. Gray, pianista e direttrice dell'ensemble musicale dell'Accademia Nazionale delle Scienze Usa, l'articolo è tra le prime uscite ufficiali degli esponenti della biomusicologia, nascente settore d'indagine un po' in odore di New Age, che {! intende rivoluzionare completamente lo studio dei suoni della natura cercando le basi biologiche della creazione musicale e del gusto della musica. :: marker3 !}<br>Accolta con qualche freddezza da parte del mondo scientifico, la nuova disciplina ritiene di aver già trovato parecchi indizi di musicalità animale. {! I canti delle megattere, ad esempio, le più 'virtuose' tra tutte le balene, presenterebbero forti somiglianze strutturali con quelli degli uccelli e degli umani, con 'frasi' di lunghezza simile alle nostre frasi musicali, ed intervalli come quelli delle nostre scale. :: marker0 !} Le balene inoltre {! mescolano elementi percussivi e toni puri in un rapporto analogo a quello utilizzato nella musica sinfonica. :: marker0 !} E come se non bastasse, {! le composizioni vocali delle megattere contengono ritornelli e rime :: marker0 !}: usate forse, scrive la Gray, come trucco per memorizzare più facilmente i canti [...].<br>{! La musica, insomma, è un linguaggio ancor più universale di quanto si pensi :: marker2 !}, tanto da far pensare che in qualche momento della storia evolutiva, balene, uccelli e uomini abbiano avuto addirittura un {! 'antenato musicale' in comune :: marker2 !}, di cui porteremmo le tracce nelle aree più arcaiche del nostro cervello. E se le radici della musica sono così remote, forse si spiega anche la forza delle emozioni che ci può regalare. A noi, e naturalmente alle balene e agli scriccioli.";

		// markers
		$this->parameters['markers'] = $this->arguments['markers'] ?? [
			['label' => 'Quali prove vengono addotte?'],
			['label' => 'Dove sono state pubblicate le tesi della?'],
			['label' => 'Quali sono le tesi della biomusicologia?'],
			['label' => 'Qual è lo scopo della biomusicologia?'],
		];

		// process the text
		function process_text($text) {
			$partId = 0;
			$processedText = $text;

			while (strpos($processedText, '{!')) {
				$partId++;

				// split text
				$previousText = explode('{! ', $processedText, 2)[0];
				$activePart = explode(' !}', explode('{! ', $processedText, 2)[1])[0];
				$followingText = explode(' !}', $processedText, 2)[1];

				// generate the active text
				$selected = test()->completed && (in_array($partId, test()->rawResults));
				$activePart = explode(' :: ', $activePart);
				$activeText = $activePart[0];
				$activeText = '
					<span class="selectable js-selectable ' . ($selected ? 'active' : '') . '" data-text-type="' . $activePart[1] . '">
						<input type="checkbox" class="hidden js-field" name="field[]" value="' . $partId . '">
						' . $activeText . '
					</span>
				';

				$processedText = $previousText . $activeText . $followingText;
			}

			return $processedText;
		}

		$this->parameters['processedText'] = process_text($text);

		// count occurances
		array_walk($this->parameters['markers'], function (&$marker, $key) use ($text) {
			$marker['count'] = substr_count($text, ' marker' . $key);
		});

		$this->resultCount = substr_count($text, ':: marker');
	}

	/**
	 * Template
	 */
	protected function template() {
		ob_start();
?>

		<div class="grid" data-spacing="800">
			<div class="grid" data-spacing="700">

				<?php if (test()->completed) { ?>

					<p class="txt-15rem fa-center">Hai associato il <strong><?= test()->percentage ?>%</strong> dei marcatori.</p>

				<?php } ?>

				<h2 class="section-title fa-center">Testo</h2>
				<p id="text" class="txt-11rem" data-selecting="">
					<?= $this->parameters['processedText'] ?>
				</p>

				<?php if (!test()->completed && !isSupervisor()) { ?>

					<div class="test__text-selectors flex center-content" data-columns="15rem" data-spacing="400">

						<?php foreach ($this->parameters['markers'] as $markerKey => $marker) { ?>

							<div class="test-selector clickable js-start-selecting" data-text-type="marker<?= $markerKey ?>" data-count="<?= $marker['count'] ?>">
								<p class=""><?= $marker['label'] ?></p>
							</div>

						<?php } ?>

					</div>

				<?php } ?>

			</div>

			<?php if (!test()->completed) { ?>
				<label>
					<p class="txt-c3 clickable inlb">Non riesco a trovare altre sezioni del testo e voglio salvare il risultato.</p>
					<button type="submit" name="review" class="hidden"></button>
				</label>
			<?php } ?>
		</div>

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
				const textBlock = document.querySelector('#text')
				const startSelectingSelector = '.js-start-selecting'
				const selectableItemSelector = '.js-selectable'

				// start selecting
				document.querySelectorAll(startSelectingSelector).forEach((element) => {
					element.addEventListener('click', () => {
						if (!element.classList.contains('disabled')) {
							const selectingType = element.dataset.textType

							textBlock.dataset.selecting = selectingType
						}
					})
				})

				// click on a selector
				document.querySelectorAll(selectableItemSelector).forEach((element) => {
					element.addEventListener('click', () => {
						const selectingType = textBlock.dataset.selecting

						if (selectingType && element.dataset.textType == selectingType && !element.classList.contains('active')) {
							const selector = document.querySelector(startSelectingSelector + '[data-text-type="' + selectingType + '"]')
							const count = selector.dataset.count - 1

							element.classList.add('active')
							element.querySelector('input').checked = true
							element.querySelector('input').dispatchEvent(changeEvent)
							selector.dataset.count = count

							if (!count) {
								selector.classList.add('disabled')
							}
						}
					})
				})

				// click on the text
				textBlock.addEventListener('click', function() {
					textBlock.dataset.selecting = null
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
			#text {
				width: fit-content;
				margin-inline: auto;
				line-height: 2;
			}

			#text {
				&[data-selecting="marker0"] {
					cursor: url('<?= client_path('/pages/assets/skills/imparare/analizzare/conseguenza.png') ?>'), pointer;
				}

				&[data-selecting="marker1"] {
					cursor: url('<?= client_path('/pages/assets/skills/imparare/analizzare/argomento.png') ?>'), pointer;
				}

				&[data-selecting="marker2"] {
					cursor: url('<?= client_path('/pages/assets/skills/imparare/analizzare/causa.png') ?>'), pointer;
				}

				&[data-selecting="marker3"] {
					cursor: url('<?= client_path('/pages/assets/skills/imparare/analizzare/scopo.png') ?>'), pointer;
				}

				&[data-selecting="marker4"] {
					cursor: url('<?= client_path('/pages/assets/skills/imparare/analizzare/dove.png') ?>'), pointer;
				}

				&[data-selecting="marker5"] {
					cursor: url('<?= client_path('/pages/assets/skills/imparare/analizzare/come.png') ?>'), pointer;
				}
			}

			.selectable.active {
				color: #000;
				background-color: var(--_type-color);

				&.wrong {
					background-color: var(--color-bad-400);
				}
			}

			/* Selectable */
			[data-text-type='marker0'] {
				--_type-color: #a189f6;
			}

			[data-text-type='marker1'] {
				--_type-color: #6bb1f9;
			}

			[data-text-type='marker2'] {
				--_type-color: #ffcf3b;
			}

			[data-text-type='marker3'] {
				--_type-color: #6dcf25;
			}

			[data-text-type='marker4'] {
				--_type-color: #f689d3;
			}

			[data-text-type='marker5'] {
				--_type-color: #fa5555;
			}

			/* Selectors */
			.completed #selectors {
				pointer-events: none;
			}

			.test-selector {
				display: grid;
				align-items: center;
				padding: 1em 1em;
				min-height: 6rem;
				border-radius: var(--border-radius-400);
				background-color: var(--_type-color);
				text-align: center;
				transition: background 0.4s, box-shadow 0.4s;

				& .active {
					box-shadow: 0 15px 40px -15px rgba(0, 0, 0, 0.5);
				}

				&.disabled,
				&[data-count="0"] {
					background-color: #ccc;
				}
			}

			.test-selector p {
				font-size: 1.2rem;
				line-height: 1.2;
				transition: color 0.3s;
			}

			.test-selector.disabled .font-bold {
				color: inherit;
			}

			.test-selector.disabled p {
				color: #fff;
			}

			/* Responsive */
			@media (max-width: 480px) {
				.selector p {
					font-size: 0.9rem;
				}
			}
		</style>

<?php return ob_get_clean();
	}

	/**
	 * Post methods
	 */
	public function calcResult(array $results = [], int $count = null) {
		return percent(count($results), $count);
	}
}
