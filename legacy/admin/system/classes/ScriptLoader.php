<?php

class ScriptLoader {

	use Singleton;

	private static $list = [];
	private static $headInlineScripts = [];
	private static $footInlineScripts = [];

	private function __construct() {
		// node packages
		if (file_exists($configFile = server_path('/package.json'))) {
			$config = file_get_contents($configFile);
			$config = json_decode($config, true);

			// setup the packages
			foreach ($config['dependencies'] as $packageName => $_looping) {
				$packageDirectory = '/node_modules/' . strtolower($packageName) . '/dist';
				$packageFile = $packageName . '.min.js';
				$packagePath = $packageDirectory . '/' . $packageFile;

				if (!file_exists(server_path($packagePath)) && file_exists(server_path($packageDirectory))) {
					$packageFiles = glob(server_path($packageDirectory . '/*.min.js'));
					$packagePath = explode(server_root(), ($packageFiles)[0])[1] ?? null;
				}

				if (!$packagePath || !file_exists(server_path($packagePath))) {
					$packagePath = '/node_modules/' . $packageName . '/' . $packageFile;
				}

				self::add($packagePath, 'static', 1);
			}
		}

		// add system scripts
		$files = glob(server_path('/system/scripts/*.js'));

		foreach ($files as $file) {
			self::add(self::getFileName($file), 'system');
		}

		// add app scripts
		$files = glob(server_path('/app/scripts/*.js'));

		foreach ($files as $file) {
			self::add(self::getFileName($file), 'app');
		}
	}

	// load a script
	public static function add($fileName, $type, $priority = false) {
		$file = false;

		switch ($type) {
			case 'system':
				// system scripts
				$file = '/system/scripts/' . $fileName . '.js';
				$priority = $priority ?: 2;

				break;

			case 'app':
				// app scripts
				$file = '/app/scripts/' . $fileName . '.js';
				$priority = $priority ?: 3;

				break;

			case 'template':
				// template scripts
				if (file_exists(server_path($fetchingFile = '/app/templates/scripts/' . $fileName . '.js'))) {
					$file = $fetchingFile;
					$priority = $priority ?: 3;
				} else if (file_exists(server_path($fetchingFile = '/system/templates/scripts/' . $fileName . '.js'))) {
					$file = $fetchingFile;
					$priority = $priority ?: 2;
				}

				break;

			case 'page':
				if (file_exists(server_path($fetchingFile = '/pages/scripts/' . $fileName . '.js'))) {
					$file = $fetchingFile;
					$priority = $priority ?: 4;
				}

				break;

			case 'static':
				$file = $fileName;
				$priority = $priority ?: 5;

				break;
		}

		// store the file URL in the list
		if ($file) {
			$file .= '?v=' . filemtime(server_path($file));
			self::$list[] = [$priority, $file];
		}
	}

	public static function addPageScripts($pageName) {
		$pageScripts = glob(server_path('/pages/scripts/-expands-' . $pageName . '/*.js'));

		self::add($pageName, 'page');

		foreach ($pageScripts as $pageScript) {
			self::add('-expands-' . $pageName . '/' . self::getFileName($pageScript), 'page', 5);
		}
	}

	// get the file name
	private static function getFileName($fileUrl) {
		return explode('.js', explode_and_pop('/', $fileUrl))[0];
	}

	/**
	 * Load the scripts
	 */
	// load all the scripts
	public  function load() {
		$list = [];

		sort_subvalue(self::$list, 0);

		foreach (self::$list as $style) {
			$list[] = '<script src="' . client_path($style[1]) . '"></script>';
		}

		return implode(PHP_EOL, $list);
	}

	// load the inline script to be placed in the head
	public function loadHeadInline() {
		return implode(PHP_EOL . PHP_EOL, self::$headInlineScripts);
	}

	// load the inline script to be placed at the end of the body
	public function loadFootInline() {
		return implode(PHP_EOL . PHP_EOL, self::$footInlineScripts);
	}
}
