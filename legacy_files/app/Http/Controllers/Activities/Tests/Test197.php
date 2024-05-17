<?php

namespace app\Http\Controllers\Activities\Tests;

use app\Http\Controllers\Activities\Test;


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
class Test197 extends Test196 {

	use \System\Traits\Singleton;

	// protected $skipEnabled = true;
	// protected $retryEnabled = true;
	// protected $buttonIsProgressive = true;
	// protected $arguments = [];

	/**
	 * Initialize
	 */
	private function __construct() {
		$this->arguments['text'] = "La vetrina del giocattolaio era piena di piccole meraviglie{{ selector }} carretti con tanto di cavallino bardato{{ selector }} con le ruote di ferro verniciate di verde e piene di vero fieno{{ selector }} un castello tutto torri irte di sentinelle armate e fiammeggianti di bandiere{{ selector }} con il ponte levatoio da far andare su e giù con la carrucola{{ selector }} piccoli treni con la ciminiera abbuiata dal  fumo denso del carbone{{ selector }} con il macchinista in testa a scrutare la lunga corsa dei binari{{ selector }} pagliacci dall’espressione stupita e malinconica che si dondolavano pigramente appesi a fili invisibili{{ selector }} su e giù{{ selector }} nell’acrobazia più difficile di questo mondo.  I bambini con il viso arrossato dal vento si fermavano incantati davanti alla vetrina. Talvolta il loro sguardo si incrociava{{ selector }} di là dai giochi{{ selector }} con le pupille sempre sonnacchiose di Leo{{ selector }} il gatto rosso con il muso affondato nel suo pelo morbido e caldo.";

		$this->arguments['correctAnswers'] = [
			3, 1, 4, 1, 4, 1, 4, 1, 1, 1, 1, 1
		];
	}
}
