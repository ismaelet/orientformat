<?php

namespace app\Http\Controllers\Activities\Tests;

use app\Http\Controllers\Activities\Test;
use Singleton;

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
class ImparareMappa extends Test {

	use Singleton;

	// protected $skipEnabled = true;
	// protected $retryEnabled = true;
	// protected $buttonIsProgressive = true;
	// protected $arguments = [];

	/**
	 * Initialize
	 */
	private function __construct() {
		// $this->arguments[''] = null;
	}

	protected function init() {
		$this->view();

		return $this;
	}

	/**
	 * Logic
	 */
	protected function logic() {
		// $this->parameters['content'] = null;
		// $this->resultCount = 0;
	}

	/**
	 * Template
	 */
	protected function template() {
		ob_start();
?>

		<section></section>

	<?php return ob_get_clean();
	}

	/**
	 * Scripts
	 */
	protected function scripts() {
		ob_start();
	?>

		<script defer>
		</script>

	<?php return ob_get_clean();
	}

	/**
	 * Style
	 */
	protected function style() {
		ob_start();
	?>

		<style>
		</style>

<?php return ob_get_clean();
	}

	/**
	 * Post methods
	 */
	public function calcResult(array $results = [], int $count = null) {
		return 100;
	}
}
