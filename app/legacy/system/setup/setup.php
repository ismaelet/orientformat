<?php

/**
 * Import Composer dependencies
 */

use Legacy\AppSetup;

require_once __DIR__ . '/../../../vendor/autoload.php';
require_once(__DIR__ . '/../classes/Setup.php');

// Define the class and trait autoloader
spl_autoload_register(function ($name) {
	$name = str_replace('\\', '/', $name);

	switch (true) {
		case file_exists($file = server_path('/' . $name . '.php')):
			include_once($file);
			break;
		case file_exists($file = server_path('/app/Models/' . str_replace('LegacyModels/', '', $name) . '.php')):
			include_once($file);
			break;
		case file_exists($file = server_path('/app/classes/' . str_replace('Legacy/', '', $name) . '.php')):
			include_once($file);
			break;
		case file_exists($file = server_path('/system/classes/' . $name . '.php')):
			include_once($file);
			break;
		case file_exists($file = server_path('/system/classes/' . str_replace('System/Classes/', '', $name) . '.php')):
			include_once($file);
			break;
		case file_exists($file = server_path('/system/traits/' . str_replace('System/Traits/', '', $name) . '.php')):
			include_once($file);
			break;
	}
});

// Run the setup
\Legacy\System\Classes\Setup::run();

AppSetup::run();

// Render the page
\App\Legacy\LegacyRoute::run();
