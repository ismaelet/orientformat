<?php

namespace Legacy\Http\Controllers\Activities\Tests;

use Illuminate\Foundation\Vite;
use Legacy\Http\Controllers\Activities\Test;
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
class ImparareMappa extends Test
{
    use Singleton;

    // protected $skipEnabled = true;
    protected $retryEnabled = true;

    protected $buttonIsProgressive = true;

    protected $arguments = [];

    /**m ,nb
     * Initialize
     */
    private function __construct()
    {
        $this->arguments['boxes'] = [
            1 => ['content' => __('tests.202-label-1'), 'autofilled' => 1, 'type' => 1, 'connections' => [2 => 'right,left']],
            2 => ['content' => __('tests.202-label-2'), 'autofilled' => 0, 'type' => 2, 'connections' => [3 => 'right,left']],
            3 => ['content' => __('tests.202-label-3'), 'autofilled' => 0, 'type' => 1, 'connections' => [4 => 'bottom,top']],
            4 => ['content' => __('tests.202-label-4'), 'autofilled' => 0, 'type' => 2, 'connections' => [5 => 'bottom,right', 6 => 'bottom,left']],
            5 => ['content' => __('tests.202-label-5'), 'autofilled' => 0, 'type' => 1, 'connections' => [7 => 'bottom,left', 8 => 'bottom,top', 9 => 'bottom,right']],
            6 => ['content' => __('tests.202-label-6'), 'autofilled' => 0, 'type' => 1, 'connections' => [10 => 'bottom,top']],
            7 => ['content' => __('tests.202-label-7'), 'autofilled' => 1, 'type' => 2, 'connections' => [11 => 'bottom,top']],
            8 => ['content' => __('tests.202-label-8'), 'autofilled' => 0, 'type' => 2, 'connections' => [12 => 'bottom,top']],
            9 => ['content' => __('tests.202-label-9'), 'autofilled' => 0, 'type' => 2, 'connections' => [13 => 'bottom,top']],
            10 => ['content' => __('tests.202-label-10'), 'autofilled' => 1, 'type' => 2, 'connections' => [14 => 'bottom,top']],
            11 => ['content' => __('tests.202-label-11'), 'autofilled' => 0, 'type' => 1, 'connections' => [15 => 'bottom,top']],
            12 => ['content' => __('tests.202-label-12'), 'autofilled' => 0, 'type' => 1, 'connections' => [16 => 'bottom,top']],
            13 => ['content' => __('tests.202-label-13'), 'autofilled' => 0, 'type' => 1, 'connections' => [17 => 'bottom,top']],
            14 => ['content' => __('tests.202-label-14'), 'autofilled' => 0, 'type' => 1],
            15 => ['content' => __('tests.202-label-15'), 'autofilled' => 0, 'type' => 2, 'connections' => [18 => 'bottom,top']],
            16 => ['content' => __('tests.202-label-16'), 'autofilled' => 0, 'type' => 2, 'connections' => [19 => 'bottom,top']],
            17 => ['content' => __('tests.202-label-17'), 'autofilled' => 1, 'type' => 2, 'connections' => [20 => 'bottom,top']],
            18 => ['content' => __('tests.202-label-18'), 'autofilled' => 0, 'type' => 1, 'connections' => [21 => 'bottom,top']],
            19 => ['content' => __('tests.202-label-19'), 'autofilled' => 1, 'type' => 1],
            20 => ['content' => __('tests.202-label-20'), 'autofilled' => 0, 'type' => 1],
            21 => ['content' => __('tests.202-label-21'), 'autofilled' => 0, 'type' => 2, 'connections' => [22 => 'bottom,left', 23 => 'bottom,right']],
            22 => ['content' => __('tests.202-label-22'), 'autofilled' => 0, 'type' => 1],
            23 => ['content' => __('tests.202-label-23'), 'autofilled' => 1, 'type' => 1],
        ];
    }

    protected function init()
    {
        $this->view();

        return $this;
    }

    /**
     * Logic
     */
    protected function logic()
    {
        $boxes = $this->arguments['boxes'];

        $i = 0;
        foreach ($boxes as $key => &$box) {
            if (! $box['autofilled']) {
                $i++;
            }

            if (legacy_test()->completed) {
                $box['classes'] = $box['autofilled'] || legacy_test()->rawResults[$i - 1] == $key || (isset($box['alternatives']) && in_array(legacy_test()->rawResults[$i - 1], $box['alternatives'])) ? 'right' : 'wrong';
                $box['text'] = $box['autofilled'] ? $box['content'] : ($boxes[legacy_test()->rawResults[$i - 1]]['content'] ?? false);
            } else {
                $box['classes'] = $box['autofilled'] ? 'active' : 'droppable';
                $box['text'] = $box['autofilled'] ? $box['content'] : '';
            }
        }

        $this->resultCount = $i;
        $this->parameters['boxes'] = $boxes;
    }

    /**
     * Template
     */
    protected function template()
    {
        ob_start();
        ?>

		<section>

			<?php if (legacy_test()->completed || ! isSupervisor()) { ?>

				<h3 class="section-title center-content">Schema</h3>

				<div class="test-content">
					<div id="graph-box" class="schema pos-rel">
						<div id="graph" class="pos-rel">

							<?php foreach ($this->parameters['boxes'] as $key => $box) { ?>

								<div id="box<?= $key ?>" class="box gradient-overlay <?= $box['classes'] ?> <?= $box['type'] == 1 ? 'box--solid js-box--solid' : 'box--dashed js-box--dashed' ?>" data-connections='<?= isset($box['connections']) ? json_encode($box['connections']) : '' ?>'>

									<p class="txt-wht txt-1rem cenY wid-100 fa-center"><?= $box['text'] ?></p>

									<?php if (! $box['autofilled']) { ?>

										<input type="hidden" class="filler-inp" name="field[]" value="0">

										<div class="reset clickable icon-box">
											<?= embed_icon('close') ?>
										</div>

									<?php } ?>

								</div>

							<?php } ?>

						</div>
					</div>

					<?php if (! legacy_test()->completed) { ?>

						<div class="elements">
							<div class="elements__wrapper panel">
								<h3 class="section-title center-content mar-b-2">Elementi</h3>
								<div id="causes" class="">
									<div class="flex-line">

										<?php
                                                $keys = array_keys($this->parameters['boxes']);
					    shuffle($keys);

					    foreach ($keys as $key) {
					        $box = $this->parameters['boxes'][$key];
					        if (! $box['autofilled'] && $box['type'] == 1) { ?>

												<div id="cause<?= $key ?>" class="cause cause--solid js-box--solid" data-id="<?= $key ?>">
													<p class="txt-wht txt-1rem"><?= $box['content'] ?></p>
												</div>

										<?php }
					        } ?>

									</div>

									<div class="flex-line">
										<?php foreach ($this->parameters['boxes'] as $key => $box) {
										    if (! $box['autofilled'] && $box['type'] == 2) { ?>

												<div id="cause<?= $key ?>" class="cause cause--dashed js-box--dashed" data-id="<?= $key ?>">
													<p class="txt-wht txt-1rem"><?= $box['content'] ?></p>
												</div>

										<?php }
										    } ?>
									</div>
								</div>
							</div>
						</div>

					<?php } ?>
				</div>

			<?php } elseif (isSupervisor()) { ?>

				<?= no_results() ?>

			<?php } ?>

		</section>


	<?php return ob_get_clean();
    }

    /**
     * Scripts
     */
    protected function scripts()
    {
        return (string) app(Vite::class)('resources/js/exercises/templates/mapping.js');
    }

    /**
     * Style
     */
    protected function style()
    {
        ob_start();
        ?>

		<style>
			main {
				--wrap-width: 100%;
				overflow: unset;
			}

			.title__wrapper {
				text-align: center;
			}

			.test-content {
				display: grid;

				@media (min-width: 1441px) {
					grid-template-columns: minmax(0, 1fr) max-content;
				}
			}

			/* Graph */
			#graph-box {
				overflow-x: auto;
			}

			#graph {
				display: grid;
				grid-template-columns: repeat(11, minmax(0, 1fr));
				grid-template-areas:
					" box1  box1 .     box2  box2  .     box3  box3   .     .     .    "
					".     .     .     .     .     .     box4  box4   .     .     .    "
					".     .     .     box5  box5  .     .     .      .     box6  box6 "
					".     box7  box7  box8  box8  box9  box9  .      .     box10 box10"
					".     box11 box11 box12 box12 box13 box13 .      .     box14 box14"
					".     box15 box15 box16 box16 box17 box17 .      .     .     .    "
					".     box18 box18 box19 box19 box20 box20 .      .     .     .    "
					".     box21 box21 .     .     .     .     .      .     .     .    "
					"box22 box22 box23 box23 .     .     .     .      .     .     .    ";

				gap: 3.5rem 2rem;
				min-width: 960px;
				margin-block: 5rem;
				margin-inline: auto;
				padding-inline: 2rem;
			}

			@media (max-width: 960px) {
				.leader-line {
					display: none;
				}
			}

			/* Boxes */
			.box,
			.cause {
				padding: 1rem 2rem;
				border-radius: var(--border-radius-700);
				text-align: center;
			}

			.box {
				position: relative;
				z-index: 1;
				display: grid;
				place-content: center;
				width: 100%;
				min-height: min(5rem, 10vh);
				background-color: var(--color-tertiary-200);
				transition: box-shadow 0.3s;

				&:nth-child(1) {
					grid-area: box1;
				}

				&:nth-child(2) {
					grid-area: box2;
				}

				&:nth-child(3) {
					grid-area: box3;
				}

				&:nth-child(4) {
					grid-area: box4;
				}

				&:nth-child(5) {
					grid-area: box5;
				}

				&:nth-child(6) {
					grid-area: box6;
				}

				&:nth-child(7) {
					grid-area: box7;
				}

				&:nth-child(8) {
					grid-area: box8;
				}

				&:nth-child(9) {
					grid-area: box9;
				}

				&:nth-child(10) {
					grid-area: box10;
				}

				&:nth-child(11) {
					grid-area: box11;
				}

				&:nth-child(12) {
					grid-area: box12;
				}

				&:nth-child(13) {
					grid-area: box13;
				}

				&:nth-child(14) {
					grid-area: box14;
				}

				&:nth-child(15) {
					grid-area: box15;
				}

				&:nth-child(16) {
					grid-area: box16;
				}

				&:nth-child(17) {
					grid-area: box17;
				}

				&:nth-child(18) {
					grid-area: box18;
				}

				&:nth-child(19) {
					grid-area: box19;
				}

				&:nth-child(20) {
					grid-area: box20;
				}

				&:nth-child(21) {
					grid-area: box21;
				}

				&:nth-child(22) {
					grid-area: box22;
				}

				&:nth-child(23) {
					grid-area: box23;
				}

				&:nth-child(24) {
					grid-area: box24;
				}

				&:nth-child(25) {
					grid-area: box25;
				}

				&:nth-child(26) {
					grid-area: box26;
				}

				&:nth-child(27) {
					grid-area: box27;
				}

				&:nth-child(28) {
					grid-area: box28;
				}

				&:nth-child(29) {
					grid-area: box29;
				}
			}

			.box::before {
				border-radius: inherit;
			}

			.elements {
				display: grid;
				align-items: flex-start;

				@media (min-width: 1441px) {
					width: 20rem;
				}
			}

			.elements__wrapper {
				position: sticky;
				top: 0;
			}

			#causes {
				display: flex;
				flex-wrap: wrap;
				justify-content: center;
				gap: 1rem;
			}

			.cause {
				display: grid;
				place-content: center;
				flex-grow: 1;
				height: 4.2rem;
				cursor: move;
			}

			.box--solid.active,
			.cause--solid {
				background-color: var(--color-tertiary-400);
			}

			.box.active,
			.box.right,
			.box.wrong {
				box-shadow: 0 22px 15px -20px var(--color-tertiary-400);
			}

			.box.right {
				background-color: var(--color-good-400);
			}

			.box.wrong {
				background-color: var(--color-bad-400);
			}

			.box--dashed,
			.cause--dashed {
				background-color: #ddd;
				border: 2px dashed var(--color-tertiary-400);

				&:not(.right):not(.wrong) p {
					color: var(--color-tertiary-400);
					font-weight: var(--font-weight-medium);
				}
			}

			.reset {
				--_fill: red;
				display: none;
				width: 1.2rem;
				aspect-ratio: 1;
				position: absolute;
				top: -0.3rem;
				right: -0.3rem;
			}

			.box.active .reset {
				display: block;
			}
		</style>

<?php return ob_get_clean();
    }

    /**
     * Post methods
     */
    public function calcResult(array $results = [], ?int $count = null)
    {
        $boxes = $this->arguments['boxes'];

        $rightN = 0;
        $i = 0;

        foreach ($boxes as $key => $box) {
            if (! $box['autofilled']) {
                $i++;
                $value = $results[$i - 1];

                if ($value == $key || (isset($box['alternatives']) && in_array($value, $box['alternatives']))) {
                    $rightN++;
                }
            }
        }

        return percent($rightN, $count);
    }
}
