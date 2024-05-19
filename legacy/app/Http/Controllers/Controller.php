<?php

namespace app\Http\Controllers;

use ScriptLoader;
use StyleLoader;
use View;

class Controller {
	private $template = '';
	private $inlineStyles = [];
	private $inlineScripts = [];
	private $parameters = [];

	/**
	 * Initilize
	 */
	public function index() {
		// preload the scripts
		foreach ($this->inlineScripts as $script) {
			\App\Legacy\ScriptLoader::getInstance()->add($script, 'inline');
		}

		// preload the styles
		foreach ($this->inlineStyles as $style) {
			\App\Legacy\StyleLoader::getInstance()->add($style, 'inline');
		}

		// store the parameters
		foreach ($this->parameters as $parameter => $parameterValue) {
			\App\Legacy\LegacyView::getInstance()->set($parameter, $parameterValue);
		}
	}

	/**
	 * Render the template
	 */
	public function render() {
		return $this->template;
	}

	/**
	 * Store the test template
	 */
	protected function storeTemplate($html) {
		$this->template = $html;

		return $this;
	}

	/**
	 * Store the test inline scripts
	 */
	protected function storeInlineScripts(array $scripts = []) {
		foreach ($scripts as $script) {
			array_push($this->inlineScripts, $script);
		}

		return $this;
	}

	/**
	 * Store the test inline styles
	 */
	protected function storeInlineStyles(array $styles = []) {
		foreach ($styles as $style) {
			array_push($this->inlineStyles, $style);
		}

		return $this;
	}

	/**
	 * Store the parameters
	 */
	protected function storeParameters(array $parameters = []) {
		$this->parameters = array_merge($this->parameters, $parameters);


		return $this;
	}
}
