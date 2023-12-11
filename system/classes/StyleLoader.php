<?php

class StyleLoader {

	use Singleton;

	private static $styleFiles = [];

	private function __construct() {
		// add system styles
		self::add(true, 'base');

		$files = glob(server_path('/system/styles/*.css'));

		foreach ($files as $file) {
			self::add(self::getFileName($file), 'system');
		}

		// add app styles
		$files = glob(server_path('/app/styles/*.css'));

		foreach ($files as $file) {
			self::add(self::getFileName($file), 'app');
		}
	}

	// add a style
	public static function add($content, $type, $priority = null) {
		$file = false;

		switch ($type) {
			case 'base':
				$file = '/public/assets/css/style.css';
				$priority = 0;
				break;

			case 'system':
				$file = '/system/styles/' . $content . '.css';
				if (!$priority) $priority = 1;
				break;

			case 'app':
				$file = '/app/styles/' . $content . '.css';
				if (!$priority) $priority = 3;
				break;
			case 'template':
				if (file_exists(SERVER_ROOT . $fetchingFile = '/app/templates/styles/' . $content . '.css')) {
					$file = $fetchingFile;
					if (!$priority) $priority = 3;
				} else if (file_exists(SERVER_ROOT . $fetchingFile = '/system/templates/styles/' . $content . '.css')) {
					$file = $fetchingFile;
					if (!$priority) $priority = 2;
				}
				break;

			case 'page':
				if (file_exists(SERVER_ROOT . $fetchingFile = '/pages/styles/' . $content . '.css')) {
					$file = $fetchingFile;
					if (!$priority) $priority = 4;
				}
				break;

			case 'static':
				$file = $content;
				if (!$priority) $priority = 6;
				break;

			case 'inline':
				if (!$priority) $priority = 7;
				break;
		}

		// store the file URL in the list
		if ($file) {
			self::$styleFiles[] = [
				'file' => $file .= '?v=' . filemtime(SERVER_ROOT . $file),
				'priority' => $priority,
				'type' => $type,
			];
		} else if ($type == 'inline') {
			self::$styleFiles[] = [
				'content' => $content,
				'priority' => $priority,
				'type' => $type,
			];
		}
	}

	// add the page style
	public static function addPageStyles($pageName) {
		$additionalStyles = glob(SERVER_ROOT . '/pages/styles/-expands-' . $pageName . '/*.css');

		self::add($pageName, 'page');

		foreach ($additionalStyles as $additionalStyle) {
			self::add('-expands-' . $pageName . '/' . self::getFileName($additionalStyle), 'page', 5);
		}
	}

	// get the file name
	private static function getFileName($fileUrl) {
		return explode('.css', explode_and_pop('/', $fileUrl))[0];
	}

	// load all the styles
	public function load() {
		sort_subvalue(self::$styleFiles, 'priority');

		$styleFiles = array_map(function ($style) {
			if ($style['type'] != 'inline') {
				return '<link href="' . client_path($style['file']) . '" rel="stylesheet" type="text/css">';
			} else {
				return $style['content'];
			}
		}, self::$styleFiles);

		return implode(PHP_EOL, $styleFiles);
	}
}
