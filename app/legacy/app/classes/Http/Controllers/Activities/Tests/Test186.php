<?php

namespace Legacy\Http\Controllers\Activities\Tests;

use Illuminate\Foundation\Vite;
use Legacy\Http\Controllers\Activities\Test;
use System\Traits\Singleton;

/**
 * @property int $resultCount = 0 <inherited>
 * @property bool $buttonIsProgressive = false <inherited>
 * @property bool $skipEnabled = false <inherited>
 * @property bool $retryEnabled = false <inherited>
 * @property array $parameters = [] <inherited>
 * @property array $arguments = []
 */
class Test186 extends Test
{
    use Singleton;

    /**
     * Test paramenters
     */
    // protected $skipEnabled = true;
    // protected $retryEnabled = true;
    // protected $arguments = [];
    protected $buttonIsProgressive = true;

    protected function init()
    {
        $this->view();

        return $this;
    }

    protected function logic()
    {
        $this->arguments['columns'] = [
            ['Ho chiari i miei obiettivi', 'Ci sono obiettivi a breve termine, come ottenere un buon voto, e obiettivi
	di più lunga durata, come diventare più esperto/a in un determinato campo.'],
            ['So programmare gli impegni', 'Non basta sapere dove si vuole arrivare, ma occorre anche sapere
	come arrivarci, con quali mezzi, anche rinunciando a qualcosa.'],
            ['Rispetto i limiti di tempo a disposizione', 'Evitare due errori opposti: obiettivi troppo ambiziosi per
	tempi troppo brevi e tempi troppo lunghi per obiettivi molto facili.'],
            ['So prendere appunti durante le lezioni', 'Scrivere richiede più tempo che parlare, quindi bisogna
	scegliere, abbreviare e organizzare le informazioni più importanti.'],
            ['Pianifico  le ripetizioni di ciò che ho studiato', 'Per trattenere e consolidare ciò che si è appreso
	bisogna imparare a ripetere, per il tempo e il numero di volte necessari.'],
            ['Faccio collegamenti fra ciò che  studio e ciò che vivo', 'Le conoscenze che non vengono applicate
	sfumano rapidamente: sono saperi inerti.'],
            ['Nelle verifiche ho spesso buoni risultati', 'I risultati positivi sono una certificazione di efficacia, però
	anche i risultati negativi servono: si cresce sugli insuccessi, se si comprende perché si è sbagliato.'],
            ['Applico  delle strategie per capire  ciò che leggo', 'Rendersi conto di non capire è il primo passo, dopo
	bisogna chiedersi che cosa fare per sciogliere i nodi.'],
        ];

        $this->resultCount = count($this->arguments['columns']);
    }

    /**
     * Template
     */
    protected function template()
    {
        ob_start();
        ?>

		<div class="grid" data-spacing="700">
			<!-- Graphic -->
			<?php if (! isSupervisor() || legacy_test()->completed) { ?>

				<section id="graphic" class="">
					<div id="graphic-pan">

						<?php foreach ($this->arguments['columns'] as $key => $column) {
						    $fieldID = $key + 1;
						    $val = legacy_test()->rawResults[$key] ?? 0;
						    ?>

							<div id="graph-col<?= $fieldID; ?>" class="graph-col js-load load--fade-in" data-direction="top" data-id="<?= $fieldID ?>">
								<input type="hidden" class="filler-inp" name="field[]" value="<?= $val ?>">
								<div class="ele-box">

									<?php for ($i = 5; $i > 0; $i--) { ?>

										<div class="graph-ele bgr-e <?= legacy_test()->completed ? 'disabled' : '' ?>" data-val="<?= $i ?>">
											<p class="score-txt font-bold txt-09rem txt-wht cen"><?= $i ?></p>
										</div>

									<?php } ?>

								</div>
								<p class="name txt-09rem"><?= $column[0] ?></p>
							</div>

						<?php } ?>

					</div>
				</section>

			<?php } ?>

			<?= no_results() ?>

			<!-- Columns descriptions -->
			<section id="desc-pan" class="">
				<div id="desc-box" class="grid stack-content">

					<?php foreach ($this->arguments['columns'] as $key => $column) {
					    $fieldID = $key + 1;
					    ?>

						<div class="field-info grid js-field-info" data-id="<?= $fieldID ?>" data-spacing="400">
							<h3 class="desc-title txt-blk font-bold txt-15rem"><?= $column[0] ?></h3>
							<p class="desc-txt txt-1rem txt-blk"><?= $column[1] ?></p>
						</div>

					<?php } ?>

				</div>
			</section>
		</div>

	<?php return ob_get_clean();
    }

    /**
     * Scripts
     */
    protected function scripts()
    {
        return (string) app(Vite::class)('resources/js/exercises/templates/graph-scores.js');
    }

    /**
     * Style
     */
    protected function style()
    {
        ob_start();
        ?>

		<style>
			/* Structure */
			.main-wrap {
				max-width: 1600px;
			}

			main {
				--_color-h-base: 100;
				--_color-h-interval: 30;
				--_color-s: 75%;
				--_color-l: 55%;
				--_color-1: hsl(calc(var(--_color-h-base) + var(--_color-h-interval) * 1), var(--_color-s), var(--_color-l));
				--_color-2: hsl(calc(var(--_color-h-base) + var(--_color-h-interval) * 2), var(--_color-s), var(--_color-l));
				--_color-3: hsl(calc(var(--_color-h-base) + var(--_color-h-interval) * 3), var(--_color-s), var(--_color-l));
				--_color-4: hsl(calc(var(--_color-h-base) + var(--_color-h-interval) * 4), var(--_color-s), var(--_color-l));
				--_color-5: hsl(calc(var(--_color-h-base) + var(--_color-h-interval) * 5), var(--_color-s), var(--_color-l));
				--_color-6: hsl(calc(var(--_color-h-base) + var(--_color-h-interval) * 6), var(--_color-s), var(--_color-l));
				--_color-7: hsl(calc(var(--_color-h-base) + var(--_color-h-interval) * 7), var(--_color-s), var(--_color-l));
				--_color-8: hsl(calc(var(--_color-h-base) + var(--_color-h-interval) * 8), var(--_color-s), var(--_color-l));
				--_color-9: hsl(calc(var(--_color-h-base) + var(--_color-h-interval) * 9), var(--_color-s), var(--_color-l));
			}

			/* Containers */
			#body {
				padding-bottom: 5rem;
			}

			/* Graphic */
			#graphic {
				overflow-x: auto;
			}

			#graphic-pan {
				display: grid;
				grid-template-columns: repeat(8, 1fr);
			}

			#graphic .name {
				writing-mode: vertical-rl;
				text-orientation: sideways;
				text-align: center;
				padding-right: 1rem;
			}

			.graph-col {
				display: grid;
				grid-template-columns: min(5rem, 20vw) 1fr;
				justify-items: left;
				width: 100%;

				&::after {
					content: '';
					width: 100%;
					grid-column: span 2;
					border-bottom: var(--border);
				}

				&:last-child::after {
					grid-column: unset;
				}

				&#graph-col1 {
					transition-delay: 0.1s;

					& .graph-ele.active {
						background-color: var(--_color-1);
					}
				}

				&#graph-col2 {
					transition-delay: 0.15s;

					& .graph-ele.active {
						background-color: var(--_color-2);
					}
				}

				&#graph-col3 {
					transition-delay: 0.2s;

					& .graph-ele.active {
						background-color: var(--_color-3);
					}
				}

				&#graph-col4 {
					transition-delay: 0.25s;

					& .graph-ele.active {
						background-color: var(--_color-4);
					}
				}

				&#graph-col5 {
					transition-delay: 0.3s;

					& .graph-ele.active {
						background-color: var(--_color-5);
					}
				}

				&#graph-col6 {
					transition-delay: 0.35s;

					& .graph-ele.active {
						background-color: var(--_color-6);
					}
				}

				&#graph-col7 {
					transition-delay: 0.4s;

					& .graph-ele.active {
						background-color: var(--_color-7);
					}
				}

				&#graph-col8 {
					transition-delay: 0.45s;

					& .graph-ele.active {
						background-color: var(--_color-8);
					}
				}

				&#graph-col9 {
					transition-delay: 0.5s;

					& .graph-ele.active {
						background-color: var(--_color-9);
					}
				}
			}

			.ele-box {
				width: 100%;
			}

			.graph-ele {
				aspect-ratio: 1;
				margin-top: 3px;
				cursor: pointer;
				position: relative;
				transition: background-color 0.3s;
			}

			.field-info {
				opacity: 0;
				translate: 0 var(--animation-movement-intensity);
				align-content: center;
				padding: 2rem 3rem;
				transition: opacity 0.2s, translate 0.2s;

				&[data-id='1'] {
					background-color: var(--_color-1);
				}

				&[data-id='2'] {
					background-color: var(--_color-2);
				}

				&[data-id='3'] {
					background-color: var(--_color-3);
				}

				&[data-id='4'] {
					background-color: var(--_color-4);
				}

				&[data-id='5'] {
					background-color: var(--_color-5);
				}

				&[data-id='6'] {
					background-color: var(--_color-6);
				}

				&[data-id='7'] {
					background-color: var(--_color-7);
				}

				&[data-id='8'] {
					background-color: var(--_color-8);
				}

				&[data-id='9'] {
					background-color: var(--_color-9);
				}
			}

			.field-info.active {
				opacity: 1;
				translate: 0 0;
			}

			.score-txt {
				display: none;
			}

			.graph-ele.last .score-txt {
				display: block;
			}

			#desc-pan {
				opacity: 1;
				transition: opacity 0.9s, max-height 0.9s;
			}

			#desc-pan.active {
				opacity: 1;
			}

			#desc-box {
				transition: background-color 0.3s, height 0.3s;
			}
		</style>

<?php return ob_get_clean();
    }

    /**
     * Post methods
     */
    public function calcResult(array $results = [], ?int $count = null)
    {
        return 100;
    }
}
