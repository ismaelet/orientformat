<?php

namespace Legacy\System\Classes;

require_once __DIR__ . '/../../public/index.php';

class Setup {

	/**
	 * Initialize constants
	 */
	static private function initializeConstants() {
		define('SERVER_ROOT', explode('/system', str_replace("\\", "/", __DIR__))[0]);
		define('CLIENT_ROOT', '/' . env('APP_SUBDOMAIN'));
		define('ICONS_DIR', '/system/assets/icons/');
		define('APP_ICONS_DIR', '/app/assets/icons/');
		define('IMG_DIR', '/app/assets/images/');
		define('LOGO_DIR', '/app/assets/logo/');
	}

	/**
	 * Initialize functions
	 */
	static private function initializeFunctions() {
		// system functions
		$modules = glob(__DIR__ . '/../functions/*.php');

		foreach ($modules as $module) {
			include_once($module);
		}

		// app functions
		$modules = glob(__DIR__ . '/../../app/functions/*.php');

		foreach ($modules as $module) {
			include_once($module);
		}
	}

	/**
	 * Initialize vendor modules
	 */
	static private function initializeVendor() {
		if (file_exists($autoloadFile = __DIR__ . '/../../vendor/autoload.php')) {
			require_once $autoloadFile;
		}
	}

	/**
	 * Initialize routes
	 */
	static private function initializeRoutes() {
		$systemRoutes = glob(__DIR__ . '/../routes/*.php');
		$appRoutes = glob(__DIR__ . '/../../app/routes/*.php');

		// system routes
		foreach ($systemRoutes as $route) {
			include_once($route);
		}

		// app routes
		foreach ($appRoutes as $route) {
			include_once($route);
		}
	}

	/**
	 * Set session language
	 */
	static private function setSessionLanguage() {
		$config = \App\Legacy\LegacyConfig::getInstance();
		$acceptedLanguages = $config->languages;
		$defaultLanguage = $config->defaultLanguage;
		$browserLanguage = !empty($_SERVER['HTTP_ACCEPT_LANGUAGE']) ? substr($_SERVER['HTTP_ACCEPT_LANGUAGE'], 0, 2) : null;
		$sessionLanguage = $_SESSION['language'] ?? null;
		$requestedLanguage = $_GET['lang'] ?? null;

		// remove unused session languages
		if ($sessionLanguage && !isset($acceptedLanguages[$sessionLanguage])) {
			$sessionLanguage = null;
			unset($_SESSION['language']);
		}

		// set the requested language
		if ($requestedLanguage && isset($acceptedLanguages[$requestedLanguage])) {
			$sessionLanguage = $_SESSION['language'] = $_GET['lang'];
		}

		// set the session language
		if (!$sessionLanguage) {
			$sessionLanguage = $_SESSION['language'] = isset($acceptedLanguages[$browserLanguage]) ? $browserLanguage : $defaultLanguage;
		}
	}

	/**
	 * Set session theme settings
	 */
	static private function setSessionTheme() {
		$_SESSION['theme-color'] = \App\Legacy\LegacyConfig::getInstance()->themeColor;
	}

	/**
	 * Run the setup
	 */
	static public function run() {
		// initialize the resources
		self::initializeConstants();
		self::initializeFunctions();
		self::initializeVendor();

		// initalize the routes
		self::initializeRoutes();

		// start the session
		session_start();

		date_default_timezone_set(\App\Legacy\LegacyConfig::getInstance()->timezone);

		self::setSessionLanguage();
		self::setSessionTheme();
	}
}
