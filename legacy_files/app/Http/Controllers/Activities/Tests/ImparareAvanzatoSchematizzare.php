<?php

namespace app\Http\Controllers\Activities\Tests;



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
class ImparareAvanzatoSchematizzare extends ImparareMappa {

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
			1 => ['content' => "Gli Yamnaya", 'autofilled' => 1, 'type' => 1, 'connections' => [2 => 'bottom,top']],
			2 => ['content' => "sono", 'autofilled' => 1, 'type' => 2, 'connections' => [3 => 'bottom,auto', 4 => 'bottom,auto', 5 => 'bottom,auto', 6 => 'bottom,auto', 7 => 'bottom,auto', 8 => 'bottom,auto']],
			3 => ['content' => "giovani", 'autofilled' => 1, 'type' => 1, 'connections' => [9 => 'bottom,left']],
			4 => ['content' => "ben nutriti", 'autofilled' => 1, 'type' => 1, 'connections' => [9 => 'bottom,top']],
			5 => ['content' => "forti", 'autofilled' => 0, 'type' => 1, 'connections' => [9 => 'bottom,right']],
			6 => ['content' => "abili guerrieri", 'autofilled' => 0, 'type' => 1, 'connections' => [10 => 'bottom,left'], 'alternatives' => [7]],
			7 => ['content' => "violenti", 'autofilled' => 0, 'type' => 1, 'connections' => [10 => 'bottom,top'], 'alternatives' => [6]],
			8 => ['content' => "senza donne", 'autofilled' => 1, 'type' => 1, 'connections' => [10 => 'bottom,right']],
			9 => ['content' => "in breve tempo", 'autofilled' => 1, 'type' => 2, 'connections' => [11 => 'bottom,top']],
			10 => ['content' => "eliminano e", 'autofilled' => 0, 'type' => 2, 'connections' => [12 => 'bottom,top']],
			11 => ['content' => "sono apprezzati dalle donne", 'autofilled' => 0, 'type' => 1, 'connections' => [13 => 'bottom,left']],
			12 => ['content' => "si sostituiscono agli uomini", 'autofilled' => 1, 'type' => 1, 'connections' => [13 => 'bottom,right']],
			13 => ['content' => "quindi c'è", 'autofilled' => 0, 'type' => 2, 'connections' => [14 => 'bottom,top']],
			14 => ['content' => "una prevalenza genetica", 'autofilled' => 0, 'type' => 1, 'connections' => [15 => 'left,top', 16 => 'right,top']],
			15 => ['content' => "quindi", 'autofilled' => 1, 'type' => 2, 'connections' => [17 => 'left,top', 18 => 'right,top']],
			16 => ['content' => "ma diventano", 'autofilled' => 0, 'type' => 2, 'connections' => [19 => 'bottom,top']],
			17 => ['content' => "scompare la civiltà precedente", 'autofilled' => 0, 'type' => 1,],
			18 => ['content' => "si afferma la loro lingua", 'autofilled' => 0, 'type' => 1, 'connections' => [20 => 'bottom,left']],
			19 => ['content' => "coltivatori, allevatori e artigiani", 'autofilled' => 1, 'type' => 1, 'connections' => [20 => 'bottom,right']],
			20 => ['content' => "si diffondono", 'autofilled' => 1, 'type' => 2, 'connections' => [21 => 'bottom,left', 22 => 'bottom,right']],
			21 => ['content' => "le lingue indo-europee", 'autofilled' => 0, 'type' => 1, 'alternatives' => [22]],
			22 => ['content' => "la proprietà privata", 'autofilled' => 0, 'type' => 1, 'alternatives' => [21]],
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
					".     .     .     .     .     box1  box1  .     .     .     .     .    "
					".     .     .     .     .     box2  box2  .     .     .     .     .    "
					"box3  box3  box4  box4  box5  box5  box6  box6  box7  box7  box8  box8 "
					".     .     box9  box9  .     .     .     .     box10 box10 .     .    "
					".     .     box11 box11 .     .     .     .     box12 box12 .     .    "
					".     .     .     .     .     box13 box13 .     .     .     .     .    "
					".     .     .     .     .     box14 box14 .     .     .     .     .    "
					".     .     .     box15 box15 .     .     box16 box16 .     .     .    "
					".     box17 box17 .     .     box18 box18 box19 box19 .     .     .    "
					".     .     .     .     .     .     box20 box20 .     .     .     .    "
					".     .     .     .     box21 box21 .     .     box22 box22 .     .    " !important;
			}
		</style>

<?php return ob_get_clean();
	}
}
