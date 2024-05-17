<?php

class Element {

	public $name;
	public $path = false;
	public $setup = false;
	public $styles = [];
	public $scripts = [];
	public $dependencies = [];

	//setup element
	function __construct($name) {

		$this->name = $name;

		//get path
		if (file_exists(__SERVER_ROOT__ . $path =  '/app/elements/' . $this->name)) $this->path = $path;
		else if (file_exists(__SERVER_ROOT__ . $path = '/system/elements/' . $this->name)) $this->path = $path;

		//load the element only if found
		if ($this->path) {

			//get setup file
			if (file_exists($file = __SERVER_ROOT__ . $this->path . '/setup.php')) $this->setup = $file;

			//get styles
			$files = glob(__SERVER_ROOT__ . $this->path . '/styles/*.css');
			foreach ($files as $file) array_push($this->styles, $file);

			//get scripts
			$files = glob(__SERVER_ROOT__ . $this->path . '/scripts/*.js');
			foreach ($files as $file) array_push($this->scripts, $file);

			//load config file
			if (file_exists($config = __SERVER_ROOT__ . $this->path . '/config.php')) include_once($config);

			//load dependencies
			if (isset($elementConfig['dependencies'])) $this->dependencies = $elementConfig['dependencies'];
		}
	}
}
