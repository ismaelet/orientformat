<?php

class View {

	use Singleton;
	use DynamicProperties;

	private static $page;
	private static $title;
	private static $description;
	private static $location;
	private static $thumbnail;
	private static $middlewares = ['public'];
	private static $template = 'main';
	private static $variables = [];

	/**
	 * Magic methods
	 */
	private function __construct() {
	}

	/**
	 * Get methods
	 */
	private function getName() {
		return self::$page;
	}

	private function getPage() {
		return self::$page;
	}

	private function getTitle() {
		return self::$title;
	}

	private function getLocation() {
		return self::$location ?: self::$page;
	}

	private function getTemplate() {
		return self::$template;
	}

	private function getVariables() {
		return self::$variables;
	}

	private function getUrl() {
		return SERVER_ROOT . '/pages/views/' . self::$page . '.php';
	}

	private function getTabTitle() {
		$config = Config::getInstance();

		if (self::$title) {
			$tabTitle = self::$title . ' | ' . Config::getInstance()->name;
		} else {
			$tabTitle = $config->name;

			if ($config->shortDescription) {
				$tabTitle .= ' | ' . $config->shortDescription;
			}
		}

		return $tabTitle;
	}

	private function getDescription() {
		return __(Config::getInstance()->description);
	}

	private function getThumbnail() {
		return self::$thumbnail ?: Config::getInstance()->clientLogo;
	}

	/**
	 * Set methods
	 */
	public static function setPage(string $page) {
		self::$page = $page;

		return new static;
	}

	public static function setTemplate(string $template) {
		self::$template = $template;

		return new static;
	}

	public static function setTitle(string $title) {
		self::$title = $title;

		return new static;
	}

	public static function setDescription(string $description) {
		self::$description = $description;

		return new static;
	}

	public static function setThumbnail(string $thumbnail = null) {
		if ($thumbnail) {
			self::$thumbnail = $thumbnail;
		}

		return new static;
	}

	public static function setLocation(string $location) {
		self::$location = $location;

		return new static;
	}

	public static function setMiddlewares(array $middlewares = []) {
		$middlewares = (array) $middlewares;

		self::$middlewares = $middlewares;

		return new static;
	}

	/**
	 * Render methods
	 */
	public function renderHeadContent() {
		$metaTags = [
			'<meta charset="utf-8">',
			'<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1.0">',
			'<meta name="description" content="' . $this->description . '">',
			'<meta property="og:image" content="' . client_path($this->thumbnail) . '">',
			'<meta property="og:description" content="' . $this->description . '">',
		];

		$metaTags = implode(PHP_EOL, $metaTags);

		$headContent = [
			$metaTags,
			'<title>' . $this->tabTitle . '</title>',
			'<!-- Styles -->' . PHP_EOL . StyleLoader::getInstance()->load(),
			'<!-- Scripts -->' . PHP_EOL . ScriptLoader::getInstance()->load(),
			'<!-- Favicon -->' . PHP_EOL . favicon(),
		];

		return implode(PHP_EOL . PHP_EOL, $headContent);
	}
	/**
	 * Misc methods
	 */
	public static function set(string $var, $value, $arrayKey = null) {
		if (!$arrayKey) {
			self::$variables[$var] = $value;
		} else {
			if (!isset(self::$variables[$var]) || !is_array(self::$variables[$var])) {
				self::$variables[$var] = [];
			}

			self::$variables[$var][$arrayKey] = $value;
		}

		return new static;
	}

	public static function get($var) {
		return self::$variables[$var] ?? null;

		return new static;
	}

	public static function addMiddlewares(array $middlewares) {
		$middlewares = (array) $middlewares;

		foreach ($middlewares as $middleware) {
			self::$middlewares[] = $middleware;
		}

		return new static;
	}

	public static function show() {
		// load the middlewares
		$middlewareLoader = MiddlewareLoader::getInstance();

		foreach (self::$middlewares as $middleware) {
			$middlewareLoader->run($middleware);
		}

		// load the logic
		Logic::add(self::$template, 'template');
		Logic::add(self::$page, 'page');
		Logic::load();

		// load page resources
		StyleLoader::addPageStyles(View::$page);
		ScriptLoader::addPageScripts(View::$page);

		// render page
		Viewer::render();
	}
}
