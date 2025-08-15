<?php

namespace Legacy\Http\Controllers\Activities\Tests;



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
class LeggereEspertoSchematizzare extends ImparareMappa {

	use \System\Traits\Singleton;

	// protected $skipEnabled = true;
	// protected $retryEnabled = true;
	// protected $buttonIsProgressive = true;
	// protected $arguments = [];

	/**
	 * Initialize
	 */
	private function __construct() {
		$this->arguments['boxes'] = [
			1 => ['content' => "L'incontro con Frank", 'autofilled' => 0, 'type' => 1, 'connections' => [3 => 'left,top', 4 => 'right,top']],
			2 => ['content' => "Morte della madre", 'autofilled' => 0, 'type' => 1, 'connections' => [5 => 'left,top', 6 => 'bottom,top', 7 => 'right,top']],
			3 => ['content' => "L'amore di Frank", 'autofilled' => 1, 'type' => 1, 'connections' => [11 => 'bottom,left']],
			4 => ['content' => "Il futuro in Argentina", 'autofilled' => 0, 'type' => 1, 'connections' => [11 => 'bottom,top']],
			5 => ['content' => "Le responsabilità", 'autofilled' => 0, 'type' => 1, 'connections' => [8 => 'bottom,auto', 9 => 'bottom,auto', 10 => 'bottom,auto']],
			6 => ['content' => "La promessa", 'autofilled' => 0, 'type' => 1, 'connections' => [12 => 'bottom,top']],
			7 => ['content' => "Il padre più vecchio e cattivo", 'autofilled' => 1, 'type' => 1, 'connections' => [12 => 'bottom,top']],
			8 => ['content' => "Il lavoro", 'autofilled' => 0, 'type' => 1, 'connections' => [11 => 'bottom,left', 12 => 'bottom,left'], 'alternatives' => [10]],
			9 => ['content' => "La casa", 'autofilled' => 1, 'type' => 1, 'connections' => [11 => 'bottom,right', 12 => 'bottom,left']],
			10 => ['content' => "I fratelli", 'autofilled' => 0, 'type' => 1, 'connections' => [11 => 'bottom,right', 12 => 'bottom,right'], 'alternatives' => [8]],
			11 => ['content' => "La fuga", 'autofilled' => 0, 'type' => 1, 'connections' => [13 => 'bottom,left']],
			12 => ['content' => "Il senso di colpa", 'autofilled' => 0, 'type' => 1, 'connections' => [13 => 'bottom,right']],
			13 => ['content' => "Panico e passività", 'autofilled' => 1, 'type' => 1,],

		];

		$this->storeInlineStyles([$this->additionalStyle()]);
	}

	protected function init() {
		$this->view();

		return $this;
	}

	/**
	 * Style
	 */
	protected function additionalStyle() {
		ob_start();
?>

		<style>
			#graph {
				grid-template-columns: repeat(12, minmax(0, 1fr)) !important;
				grid-template-areas:
					".     box1  box1  .     .     .     .     .     box2  box2  .     .    "
					"box3  box3  box4  box4  .     .     box5  box5  box6  box6  box7  box7 "
					".     .     .     .     box8  box8  box9  box9  box10 box10 .     .    "
					".     .     .     box11 box11 .     .     .     .     box12 box12 .    "
					".     .     .     .     .     .     box13 box13 .     .     .     .    " !important;
			}
		</style>

<?php return ob_get_clean();
	}
}
