<?php

namespace App\Legacy;

class LegacyView {

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
		return server_root() . '/pages/views/' . self::$page . '.php';
	}

	public static function getTabTitle() {
		$config = LegacyConfig::getInstance();

		if (self::$title) {
			$tabTitle = self::$title . ' | ' . LegacyConfig::getInstance()->name;
		} else {
			$tabTitle = $config->name;

			if ($config->shortDescription) {
				$tabTitle .= ' | ' . $config->shortDescription;
			}
		}

		return $tabTitle;
	}

	public static function getDescription() {
		return __(LegacyConfig::getInstance()->description);
	}

	public static function getThumbnail() {
		return self::$thumbnail ?: LegacyConfig::getInstance()->clientLogo;
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
		StyleLoader::addPageStyles(LegacyView::$page);
		ScriptLoader::addPageScripts(LegacyView::$page);

		// render page
		Viewer::render();
	}
}
