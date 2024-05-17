<?php

namespace app\Http\Controllers\Activities\Tests;



/**
 * Superiori > 2a > Imparare > Probabilità
 * 
 * Dependent tests: []
 */
class Test174 extends Test149 {

	use \System\Traits\Singleton;

	/**
	 * Test paramenters
	 */
	// protected $skipEnabled = true;
	// protected $retryEnabled = true;
	// protected $buttonIsProgressive = true;
	protected $arguments = [];

	protected function init() {
		$this->arguments['text'] = "
		Spesso, per divertirsi, gli uomini d’equipaggio<br>
		catturano degli albatri, grandi uccelli di mare,<br>
		che {! seguono, indolenti compagni di viaggio,<br>
		la nave :: marker0 !} che scivola sugli abissi amari.<br><br>

		Appena li hanno deposti sul ponte,<br>
		questi {! re dell’azzurro :: marker0 !}, {! maldestri e vergognosi,<br>
		lasciano cadere miseramente le grandi ali bianche :: marker1 !}<br>
		come remi inerti trascinati ai loro fianchi.<br><br>

		Quel {! viaggiatore alato :: marker0 !}, com’è {! sgraziato e remissivo! :: marker1 !}<br>
		Lui, poco fa {! così bello :: marker0 !}, com’è {! comico e brutto! :: marker1 !}<br>
		Uno gli stuzzica il becco con la pipa,<br>
		un altro imita, zoppicando, {! l’infermo :: marker1 !} che volava!<br><br>

		Il Poeta è come lui, {! principe delle nuvole :: marker0 !}<br>
		che {! sfida la tempesta :: marker0 !} e {! se la ride dell’arciere :: marker0 !};<br>
		fra le grida di scherno esule in terra,<br>
		le sue ali di gigante non gli permettono di camminare.";

		$this->arguments['markers'] = [
			['label' => 'Albatro in volo'],
			['label' => 'Albatro sul ponte'],
		];

		$this->view();

		return $this;
	}
}
