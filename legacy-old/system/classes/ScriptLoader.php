<?php

class ScriptLoader {

	use Singleton;

	private static $list = [];
	private static $headInlineScripts = [];
	private static $footInlineScripts = [];

	private function __construct() {
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
	public static function add($content, $type, $priority = false, $deferred = null) {
		$file = false;

		switch ($type) {
			case 'system':
				// system scripts
				$file = '/system/scripts/' . $content . '.js';
				$priority = $priority ?: 2;

				break;

			case 'app':
				// app scripts
				$file = '/app/scripts/' . $content . '.js';
				$priority = $priority ?: 3;

				break;

			case 'template':
				// template scripts
				if (file_exists(server_path($fetchingFile = '/app/templates/scripts/' . $content . '.js'))) {
					$file = $fetchingFile;
					$priority = $priority ?: 3;
				} else if (file_exists(server_path($fetchingFile = '/system/templates/scripts/' . $content . '.js'))) {
					$file = $fetchingFile;
					$priority = $priority ?: 2;
				}

				break;

			case 'page':
				if (file_exists(server_path($fetchingFile = '/pages/scripts/' . $content . '.js'))) {
					$file = $fetchingFile;
					$deferred = true;
					$priority = $priority ?: 4;
				}

				break;

			case 'static':
				$file = $content;
				$priority = $priority ?: 5;

				break;

			case 'third-party':
				$file = $content;
				$priority = $priority ?: 1;

				break;

			case 'inline':
				if (!$priority) $priority = 6;
				$deferred = true;
				break;
		}

		// store the file URL in the list
		if ($file) {
			self::$list[] = [
				'priority' => $priority,
				'file-name' => $file,
				'type' => $type,
				'deferred' => $deferred,
			];
		} else if ($type == 'inline') {
			self::$list[] = [
				'priority' => $priority,
				'content' => $content,
				'type' => $type,
				'deferred' => $deferred,
			];
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
		sort_subvalue(self::$list, 'priority');

		$scriptFiles = array_map(function ($script) {
			if ($script['type'] != 'inline') {
				$fullPath = $script['type'] == 'third-party' ? $script['file-name'] : client_path($script['file-name']);

				return '<script src="' . $fullPath . '" ' . ($script['deferred'] ? 'defer' : '') . '></script>';
			} else {
				return $script['content'];
			}
		}, self::$list);

		return implode(PHP_EOL, $scriptFiles);
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
