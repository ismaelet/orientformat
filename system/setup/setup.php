<?php

require_once(__DIR__ . '/../classes/Setup.php');

// Define the class and trait autoloader
spl_autoload_register(function ($name) {
	$name = str_replace('\\', '/', $name);

	switch (true) {
		case file_exists($file = server_path('/' . $name . '.php')):
			include_once($file);
			break;
		case file_exists($file = server_path('/app/classes/' . $name . '.php')):
			include_once($file);
			break;
		case file_exists($file = server_path('/system/classes/' . $name . '.php')):
			include_once($file);
			break;
		case file_exists($file = server_path('/system/traits/' . $name . '.php')):
			include_once($file);
			break;
		case file_exists($file = public_server_path('/app/classes/' . $name . '.php')):
			include_once($file);
			break;
	}
});

// Run the setup
Setup::run();

if (class_exists('EcommerceSetup')) {
	EcommerceSetup::run();
}

if (class_exists('AdminSetup')) {
	AdminSetup::run();
}

if (class_exists('AppSetup')) {
	AppSetup::run();
}

// Render the page
Route::run();
