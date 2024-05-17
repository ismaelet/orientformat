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
class LeggereAvanzatoSchematizzare extends ImparareMappa {

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
			1 => ['content' => "L’albatro", 'autofilled' => 1, 'type' => 1, 'connections' => [2 => 'bottom,left', 3 => 'bottom,right']],
			2 => ['content' => "quando è", 'autofilled' => 0, 'type' => 2, 'connections' => [4 => 'bottom,left', 5 => 'bottom,right']],
			3 => ['content' => "è come", 'autofilled' => 1, 'type' => 2, 'connections' => [6 => 'bottom,right']],
			4 => ['content' => "in volo", 'autofilled' => 0, 'type' => 1, 'connections' => [7 => 'bottom,top']],
			5 => ['content' => "sul ponte", 'autofilled' => 0, 'type' => 1, 'connections' => [8 => 'bottom,top']],
			6 => ['content' => "il poeta", 'autofilled' => 0, 'type' => 1, 'connections' => [9 => 'bottom,top']],
			7 => ['content' => "appare", 'autofilled' => 0, 'type' => 2, 'connections' => [10 => 'bottom,right', 14 => 'bottom,right', 19 => 'bottom,right', 24 => 'bottom,right']],
			8 => ['content' => "appare", 'autofilled' => 1, 'type' => 2, 'connections' => [11 => 'bottom,right', 15 => 'bottom,right', 20 => 'bottom,right', 25 => 'bottom,right']],
			9 => ['content' => "che", 'autofilled' => 1, 'type' => 2, 'connections' => [12 => 'bottom,left', 13 => 'bottom,right']],
			10 => ['content' => "bello", 'autofilled' => 1, 'type' => 1],
			11 => ['content' => "brutto", 'autofilled' => 0, 'type' => 1, 'alternatives' => [20, 25]],
			12 => ['content' => "nella vita comune", 'autofilled' => 1, 'type' => 1, 'connections' => [16 => 'bottom,top']],
			13 => ['content' => "con la poesia", 'autofilled' => 0, 'type' => 1, 'connections' => [17 => 'bottom,left', 22 => 'bottom,left', 27 => 'bottom,left']],
			14 => ['content' => "padrone del cielo", 'autofilled' => 0, 'type' => 1, 'alternatives' => [24]],
			15 => ['content' => "comico", 'autofilled' => 1, 'type' => 1],
			16 => ['content' => "è", 'autofilled' => 1, 'type' => 2, 'connections' => [21 => 'bottom,right', 26 => 'bottom,right', 29 => 'bottom,right']],
			17 => ['content' => "è", 'autofilled' => 1, 'type' => 2, 'connections' => [18 => 'right,left']],
			18 => ['content' => "padrone dell’immaginazione (le “nuvole”)", 'autofilled' => 1, 'type' => 1],
			19 => ['content' => "incurante dei pericoli", 'autofilled' => 1, 'type' => 1],
			20 => ['content' => "impacciato", 'autofilled' => 0, 'type' => 1, 'alternatives' => [11, 25]],
			21 => ['content' => "deriso", 'autofilled' => 0, 'type' => 1, 'alternatives' => [26]],
			22 => ['content' => "sfida", 'autofilled' => 0, 'type' => 2, 'connections' => [23 => 'right,left']],
			23 => ['content' => "le avversità (“la tempesta”)", 'autofilled' => 1, 'type' => 1],
			24 => ['content' => "viaggiatore indolente", 'autofilled' => 0, 'type' => 1, 'alternatives' => [14]],
			25 => ['content' => "malato", 'autofilled' => 0, 'type' => 1, 'alternatives' => [11, 20]],
			26 => ['content' => "esule", 'autofilled' => 0, 'type' => 1, 'alternatives' => [21]],
			27 => ['content' => "non teme", 'autofilled' => 0, 'type' => 2, 'connections' => [28 => 'right,left']],
			28 => ['content' => "le critiche (gli “arcieri”)", 'autofilled' => 0, 'type' => 1],
			29 => ['content' => "goffo", 'autofilled' => 1, 'type' => 1],
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
