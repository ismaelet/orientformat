<?php


/**
 * Add environment variables from the .env file
 */

use App\Support\Database\MigrationHandler;

(Dotenv\Dotenv::createImmutable(__DIR__ . '/../../'))->load();

/**
 * Set the root of the project
 */
$_ENV['SERVER_ROOT'] = explode('/bootstrap', str_replace("\\", "/", __DIR__))[0];

/**
 * Define the class autoloader
 */
spl_autoload_register(function ($className) {
	$className = str_replace('\\', '/', $className);

	switch (true) {
		case (file_exists($file = __DIR__ . '/../' . lcfirst($className) . '.php')):
			include_once($file);
			break;

		case (file_exists($file = __DIR__ . '/../app/classes/' . $className . '.php')):
			include_once($file);
			break;

		case (file_exists($file = __DIR__ . '/../system/traits/' . $className . '.php')):
			include_once($file);


		case (file_exists($file = __DIR__ . '/../system/classes/' . $className . '.php')):
			include_once($file);

			if (method_exists($className, '__constructStatic')) {
				$className::__constructStatic();
			}

			break;
	}
});

/**
 * Add helper functions
 */
$helpers = glob(__DIR__ . '/../app/Helpers/*.php', GLOB_BRACE);

foreach ($helpers as $helper) {
	include_once($helper);
}

/**
 * Check if to run a migration
 */
if (env('migrate')) {
	MigrationHandler::migrateAll();
} else if (env('rollback')) {
	MigrationHandler::rollback();
}
