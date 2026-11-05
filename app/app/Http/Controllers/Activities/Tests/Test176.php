<?php

namespace App\Http\Controllers\Activities\Tests;

use App\Http\Controllers\Activities\TestNextController;
use System\Traits\Singleton;

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
class Test176 extends TestNextController
{
    use Singleton;

    protected $retryEnabled = true;

    protected $skipEnabled = true;

    protected $buttonIsProgressive = true;

    protected $arguments = [];

    protected $options = [];

    public function __construct()
    {
        $this->arguments['correctAnswers'] = [[1], [2], [3], [4, 5], [4, 5], [6, 7], [7, 6], [8], [9], [10]];

        for ($i = 1; $i <= 20; $i++) {
            $this->options[] = ['id' => $i, 'text' => __('tests.176-missing-'.$i), 'correct' => true];
        }

        shuffle($this->options);

        $this->arguments['text'] = __('tests.176-text');
    }

    protected function init()
    {
        $this->view();

        return $this;
    }

    protected function logic()
    {

        // results
        $this->parameters['correctAnswers'] = $this->arguments['correctAnswers'];

        // text
        $text = $this->arguments['text'];

        function _process_text($text, $correctAnswers)
        {
            $text = explode('{{ place-input }}', $text);

            foreach ($text as $key => $part) {
                $element = '';

                if ($key) {
                    if (legacy_test()->completed) {
                        $elementClasses = ['test-answer'];
                        $status = in_array((legacy_test()->rawResults[$key - 1]), $correctAnswers[$key - 1]) ? 'font-bold text-success-400' : 'font-bold text-error-400';
                        array_push($elementClasses, $status);

                        $element = '<span class="'.(implode(' ', $elementClasses)).'">'.__('tests.176-missing-'.legacy_test()->rawResults[$key - 1]).'</span>';
                    } else {
                        $value = legacy_test()->rawResults[$key - 1] ?? '';
                        $element = '<label class="droppable"><span class="option"></span><input type="hidden" class=" js-field" name="field[]" value="'.$value.'" readonly></label>';
                    }
                }

                $text[$key] = $element.'<span>'.$part.'</span>';
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
    protected function template()
    {
        ob_start();
        ?>

		<section class="grid" data-spacing="700">

			<?php if (legacy_test()->completed) { ?>

				<p class=" txt-15rem fa-center"><?= __('tests.176-result', ['percentage' => legacy_test()->percentage]) ?></p>

			<?php } ?>

			<?php if (legacy_test()->completed || ! isSupervisor()) { ?>

				<div id="text-box" class="section grid grid-cols-1 gap-8">

					<h1 class="fa-center txt-3rem mar-b-2 mar-t-5 font-bold txt-upp"><?= __('Summary') ?></h1>

					<!-- Text -->
					<div class="leading-[2] text-lg summary-text"><?= $this->parameters['text'] ?></div>

					<!-- Draggable options -->
					<?php if (! legacy_test()->completed) { ?>
						<div class="flex gap-4 wrap justify-center <?= isSupervisor() ? 'pointer-events-none' : '' ?>">
							<?php foreach ($this->options as $key => $option) { ?>
								<p id="draggable-<?= $key ?>" class="border px-2 rounded-sm draggable-option draggable" draggable="true" data-id="<?= $option['id'] ?>"><?= $option['text'] ?></p>
							<?php } ?>
						</div>
					<?php } ?>

					<!-- Read the full text -->
					<p class="clickable text-transition-400 flex wrap items-center gap-2" onclick="document.querySelectorAll('.section').forEach(element => element.classList.toggle('hidden'));">
						<span class="text-icon text-c3"> <?= embed_icon('read') ?></span>
						<span class="btn-txt"><?= __('Click here to read the text again') ?></span>
					</p>
				</div>

				<div id="original-box" class="section hidden">
					<div class="grid grid-cols-1 justify-items-center">
						<h1 class="fa-center txt-3rem mar-b-2 mar-t-5 font-bold txt-upp mx-auto">Testo</h1>

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

						<p class="clickable mar-b-2 txt-c3 fc-primary-h inlb" onclick="document.querySelectorAll('.section').forEach(element => element.classList.toggle('hidden'));">
							<span class="text-icon text-tertiary-400"><?= embed_icon('navigation/back') ?></span>
							<span class="btn-txt">Clicca qui per tornare al riassunto</span>
						</p>
					</div>
				</div>

			<?php } ?>

			<?= no_results() ?>

		</section>

	<?php return ob_get_clean();
    }

    /**
     * Scripts
     */
    protected function scripts()
    {
        ob_start();
        ?>

		<script defer>
			document.addEventListener('DOMContentLoaded', () => {
				// Attach dragstart to all draggable divs
				document.querySelectorAll('.draggable').forEach(div => {
					div.addEventListener('dragstart', e => {
						e.dataTransfer.setData('text/plain', div.textContent.trim());
						e.dataTransfer.setData('elementId', div.id);
						e.dataTransfer.setData('id', div.dataset.id);
					});
				});

				// Enable inputs to accept drops
				document.querySelectorAll('.droppable').forEach(element => {
					element.addEventListener('dragover', e => e.preventDefault());

					element.addEventListener('drop', e => {
						const input = element.querySelector('input');
						const label = element.querySelector('.option');

						e.preventDefault();
						const text = e.dataTransfer.getData('text/plain');
						const id = e.dataTransfer.getData('id');
						const elementId = e.dataTransfer.getData('elementId');
						const div = document.getElementById(elementId);

						// If input already has a linked div, show it again
						if (element.dataset.divId) {
							const oldDiv = document.getElementById(element.dataset.divId);
							oldDiv.style.display = 'inline-block';
						}

						// Hide the newly dropped div
						div.style.display = 'none';

						// Update input value and remember which div it holds
						input.value = id;
						label.textContent = text;
						input.dispatchEvent(new Event('change'));
						element.dataset.divId = elementId;
					});
				});
			});
		</script>

	<?php return ob_get_clean();
    }

    /**
     * Style
     */
    protected function style()
    {
        ob_start();
        ?>

		<style>
			#text,
			#original {
				text-align: justify;
			}

			#original {
				line-height: 2;
			}

			.test-input {
				display: inline-block;
				width: 15rem;
				max-width: 100%;
				color: var(--color-tertiary-400);
				font-size: 1em;
				line-height: 2;
			}

			.test-answer {
				display: inline;
				padding: 0 1rem;
				border-bottom: 1px solid currentColor;
				font-weight: bold;

				&.test-answer--right {
					color: var(--color-good-400);
				}

				&.test-answer--wrong {
					color: var(--color-bad-400);
				}
			}

			.summary-text {
				line-height: 2.5;
				text-align: justify;
			}

			.summary-text span {
				display: inline;
			}

			.summary-text .option {
				display: inline-block;
				width: fit-content;
				min-width: 10em;
				border-radius: 0;
				line-height: 1;
				outline: none;
				border: none;
				border-bottom: 1px solid currentColor;
				background: none;
				box-shadow: none;
				text-align: center;
			}

			.draggable-option {
				cursor: grab;
			}
		</style>

<?php return ob_get_clean();
    }

    /**
     * Post methods
     */
    public function calcResult(array $results = [], ?int $count = null)
    {
        $rightAnswerCount = 0;
        $correctAnswers = $this->arguments['correctAnswers'];

        foreach ($results as $key => $result) {
            if (in_array($result, $correctAnswers[$key])) {
                $rightAnswerCount++;
            }
        }

        return percent($rightAnswerCount, $count);
    }
}
