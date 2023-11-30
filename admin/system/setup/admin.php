<?php

AdminSetup::execute();

class AdminSetup {
	// routes
	private static function initializeRoutes() {
		Logic::$dependencies['admin'] = 'void';
		Logic::$dependencies['admin-list'] = 'admin';
		Logic::$dependencies['admin-form'] = 'admin';
		Logic::$dependencies['admin-advanced'] = 'admin';
		Logic::$priorities['admin'] = 60;
		Logic::$priorities['admin-list'] = 200;
		Logic::$priorities['admin-form'] = 200;
		Logic::$priorities['admin-advanced'] = 65;
	}

	private static function initializeFunctions() {
		if (file_exists($file = __PUBLIC_SERVER_ROOT__ . '/system/functions/ecommerce.php')) require_once($file);
		if (file_exists($file = __PUBLIC_SERVER_ROOT__ . '/system/functions/ecommerce-emails.php')) require_once($file);
	}

	private static function initializeConstants() {
		define('__PUBLIC_SERVER_ROOT__', explode('/admin', __SERVER_ROOT__)[0]);
		define('__PUBLIC_CLIENT_ROOT__',  explode('/admin', __CLIENT_ROOT__)[0]);
		define('__PUBLIC_CLIENT_URL__',  explode('/admin', __CLIENT_URL__)[0]);
	}

	public static function execute() {
		self::initializeRoutes();
		self::initializeConstants();
		self::initializeFunctions();
	}
}
