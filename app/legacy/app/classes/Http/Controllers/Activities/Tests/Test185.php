<?php

namespace Legacy\Http\Controllers\Activities\Tests;



/**
 * Superiori > 2a > Imparare > Probabilità
 * 
 * Dependent tests: []
 */
class Test185 extends Test149 {

	use \System\Traits\Singleton;

	/**
	 * Test paramenters
	 */
	// protected $skipEnabled = true;
	// protected $retryEnabled = true;
	// protected $buttonIsProgressive = true;
	protected $arguments = [];

	protected function init() {
		$this->arguments['text'] = __('tests.185-text');

		$this->arguments['markers'] = [
			['label' => __('tests.185-label-1')],
		];

		$this->view();

		return $this;
	}
}
