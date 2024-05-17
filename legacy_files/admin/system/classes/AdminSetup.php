<?php

class AdminSetup {
	/**
	 * Initialize the constants
	 */
	private static function initializeConstants() {
		define('PUBLIC_SERVER_ROOT', explode('/admin', SERVER_ROOT)[0]);
		define('PUBLIC_CLIENT_ROOT',  explode('/admin', CLIENT_ROOT)[0]);
	}

	/**
	 * Initialize the templates
	 */
	private static function initializeTemplates() {
		Logic::$dependencies['admin'] = 'void';
		Logic::$dependencies['admin-list'] = 'admin';
		Logic::$dependencies['admin-form'] = 'admin';
		Logic::$dependencies['admin-advanced'] = 'admin';
		Logic::$priorities['admin'] = 60;
		Logic::$priorities['admin-list'] = 200;
		Logic::$priorities['admin-form'] = 200;
		Logic::$priorities['admin-advanced'] = 65;
	}

	/**
	 * Execute the setup
	 */
	public static function execute() {
		self::initializeConstants();
		self::initializeTemplates();
	}
}
