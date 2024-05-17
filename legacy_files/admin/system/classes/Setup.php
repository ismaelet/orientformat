<?php

class Setup {
	/**
	 * Initialize constants
	 */
	static private function initializeConstants() {
		define('SERVER_ROOT', explode('/system', str_replace("\\", "/", __DIR__))[0]);
		define('CLIENT_ROOT', $_SERVER['REMOTE_ADDR'] == '10.15.160.196' ? '/orientamento/admin' : str_replace(rtrim($_SERVER['DOCUMENT_ROOT'], '/'), '', SERVER_ROOT));
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
		$modules = glob(__DIR__ . '/../functions/*.php', GLOB_BRACE);

		foreach ($modules as $module) {
			include_once($module);
		}

		// app functions
		$modules = glob(__DIR__ . '/../../app/functions/*.php', GLOB_BRACE);

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
		// system routes
		foreach (scan('/system/routes', 'php') as $route) {
			include_once($route);
		}

		// app routes
		foreach (scan('/app/routes', 'php') as $route) {
			include_once($route);
		}
	}

	/**
	 * Migrate
	 */
	static private function migrate() {
		$config = Config::getInstance();

		if ($config->hasDatabase && $config->migrate) {
			// system migration
			foreach (scan('/system/migration', 'php') as $migrationModule) {
				include_once($migrationModule);
			}

			// app migration
			foreach (scan('/app/migration', 'php') as $migrationModule) {
				include_once($migrationModule);
			}
		}
	}

	/**
	 * Set session user
	 */
	static private function setSessionUser() {
	}

	/**
	 * Set session language
	 */
	static private function setSessionLanguage() {
		$config = Config::getInstance();
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
		$_SESSION['theme-color'] = Config::getInstance()->themeColor;
	}

	/**
	 * Run the setup
	 */
	static public function run() {
		// initialize the resources
		self::initializeConstants();
		self::initializeFunctions();
		self::initializeVendor();

		// migrate the database
		self::migrate();

		// initalize the routes
		self::initializeRoutes();

		// start the session
		session_start();

		date_default_timezone_set(Config::getInstance()->timezone);

		self::setSessionUser();
		self::setSessionLanguage();
		self::setSessionTheme();
	}
}
