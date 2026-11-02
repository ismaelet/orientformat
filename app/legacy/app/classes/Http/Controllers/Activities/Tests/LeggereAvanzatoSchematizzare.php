<?php

namespace Legacy\Http\Controllers\Activities\Tests;

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
class LeggereAvanzatoSchematizzare extends ImparareMappa
{
    use Singleton;

    // protected $skipEnabled = true;
    // protected $retryEnabled = true;
    // protected $buttonIsProgressive = true;
    // protected $arguments = [];

    /**
     * Initialize
     */
    private function __construct()
    {
        $this->arguments['boxes'] = [
            1 => ['content' => __('tests.175-label-1'), 'autofilled' => 1, 'type' => 1, 'connections' => [2 => 'bottom,left', 3 => 'bottom,right']],
            2 => ['content' => __('tests.175-label-2'), 'autofilled' => 0, 'type' => 2, 'connections' => [4 => 'bottom,left', 5 => 'bottom,right']],
            3 => ['content' => __('tests.175-label-3'), 'autofilled' => 1, 'type' => 2, 'connections' => [6 => 'bottom,right']],
            4 => ['content' => __('tests.175-label-4'), 'autofilled' => 0, 'type' => 1, 'connections' => [7 => 'bottom,top']],
            5 => ['content' => __('tests.175-label-5'), 'autofilled' => 0, 'type' => 1, 'connections' => [8 => 'bottom,top']],
            6 => ['content' => __('tests.175-label-6'), 'autofilled' => 0, 'type' => 1, 'connections' => [9 => 'bottom,top']],
            7 => ['content' => __('tests.175-label-7'), 'autofilled' => 0, 'type' => 2, 'connections' => [10 => 'bottom,right', 14 => 'bottom,right', 19 => 'bottom,right', 24 => 'bottom,right']],
            8 => ['content' => __('tests.175-label-8'), 'autofilled' => 1, 'type' => 2, 'connections' => [11 => 'bottom,right', 15 => 'bottom,right', 20 => 'bottom,right', 25 => 'bottom,right']],
            9 => ['content' => __('tests.175-label-9'), 'autofilled' => 1, 'type' => 2, 'connections' => [12 => 'bottom,left', 13 => 'bottom,right']],
            10 => ['content' => __('tests.175-label-10'), 'autofilled' => 1, 'type' => 1],
            11 => ['content' => __('tests.175-label-11'), 'autofilled' => 0, 'type' => 1, 'alternatives' => [20, 25]],
            12 => ['content' => __('tests.175-label-12'), 'autofilled' => 1, 'type' => 1, 'connections' => [16 => 'bottom,top']],
            13 => ['content' => __('tests.175-label-13'), 'autofilled' => 0, 'type' => 1, 'connections' => [17 => 'bottom,left', 22 => 'bottom,left', 27 => 'bottom,left']],
            14 => ['content' => __('tests.175-label-14'), 'autofilled' => 0, 'type' => 1, 'alternatives' => [24]],
            15 => ['content' => __('tests.175-label-15'), 'autofilled' => 1, 'type' => 1],
            16 => ['content' => __('tests.175-label-16'), 'autofilled' => 1, 'type' => 2, 'connections' => [21 => 'bottom,right', 26 => 'bottom,right', 29 => 'bottom,right']],
            17 => ['content' => __('tests.175-label-17'), 'autofilled' => 1, 'type' => 2, 'connections' => [18 => 'right,left']],
            18 => ['content' => __('tests.175-label-18'), 'autofilled' => 1, 'type' => 1],
            19 => ['content' => __('tests.175-label-19'), 'autofilled' => 1, 'type' => 1],
            20 => ['content' => __('tests.175-label-20'), 'autofilled' => 0, 'type' => 1, 'alternatives' => [11, 25]],
            21 => ['content' => __('tests.175-label-21'), 'autofilled' => 0, 'type' => 1, 'alternatives' => [26]],
            22 => ['content' => __('tests.175-label-22'), 'autofilled' => 0, 'type' => 2, 'connections' => [23 => 'right,left']],
            23 => ['content' => __('tests.175-label-23'), 'autofilled' => 1, 'type' => 1],
            24 => ['content' => __('tests.175-label-24'), 'autofilled' => 0, 'type' => 1, 'alternatives' => [14]],
            25 => ['content' => __('tests.175-label-25'), 'autofilled' => 0, 'type' => 1, 'alternatives' => [11, 20]],
            26 => ['content' => __('tests.175-label-26'), 'autofilled' => 0, 'type' => 1, 'alternatives' => [21]],
            27 => ['content' => __('tests.175-label-27'), 'autofilled' => 0, 'type' => 2, 'connections' => [28 => 'right,left']],
            28 => ['content' => __('tests.175-label-28'), 'autofilled' => 0, 'type' => 1],
            29 => ['content' => __('tests.175-label-29'), 'autofilled' => 1, 'type' => 1],
        ];

        $this->storeInlineStyles([$this->additionalStyle()]);
    }

    protected function init()
    {
        $this->view();

        return $this;
    }

    /**
     * Style
     */
    protected function additionalStyle()
    {
        ob_start();
        ?>

		<style>
			#graph {
				grid-template-columns: repeat(12, minmax(0, 1fr)) !important;
				grid-template-areas:
					".     .     .     .     box1  box1  .     .     .     .     .     .    "
					".     .     .     box2  box2  box3  box3  .     .     .     .     .    "
					".     .     box4  box4  box5  box5  box6  box6  .     .     .     .    "
					".     .     box7  box7  box8  box8  box9  box9  .     .     .     .    "
					"box10 box10 box11 box11 .     box12 box12 box13 box13 .     .     .    "
					"box14 box14 box15 box15 .     box16 box16 .     box17 box17 box18 box18"
					"box19 box19 box20 box20 box21 box21 .     .     box22 box22 box23 box23"
					"box24 box24 box25 box25 box26 box26 .     .     box27 box27 box28 box28"
					".     .     .     .     box29 box29 .     .     .     .     .     .    " !important;
			}
		</style>

<?php return ob_get_clean();
    }
}
