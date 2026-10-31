<?php

namespace App\Support;

use Illuminate\Support\Facades\Route as LaravelRoute;

class Route {

	private static $routes = [
		'GET' => [],
		'POST' => [],
	];

	/**
	 * Add a route to the list
	 */
	private static function add(string $path, string $method, callable $function): void {
        $name = 'legacy.support.'.strtolower($method).'.'.str_replace('/', '.', trim($path, '/'));
        LaravelRoute::match([$method], $path, $function)->name($name);
        LaravelRoute::getRoutes()->refreshNameLookups();

		array_push(self::$routes[$method], [
			'path' => parse_url(route($name), PHP_URL_PATH),
			'function' => $function,
			'name' => explode('/', $path, 2)[1]
		]);
	}

	/**
	 * Add a route with the GET method
	 */
	public static function get(string|array $paths, callable $function): void {

		// normalize the route data
		$paths = (array) $paths;

		// store the route
		if (!empty($paths) && $function) {
			foreach ($paths as $path) {
				if ($path[0] == '/') {
					self::add($path, 'GET', $function);
				}
			}
		}
	}

	/**
	 * Add a route with the POST method
	 */
	public static function post(string|array $paths, callable $function): void {

		// normalize the route data
		$paths = (array) $paths;

		// store the route
		if (!empty($paths) && $function) {
			foreach ($paths as $path) {
				if ($path[0] == '/') {
					self::add($path, 'POST', $function);
				}
			}
		}
	}

	/**
	 * Run the route
	 */
	public static function run(): int|bool {
		$requestUrl = parse_url($_SERVER['REQUEST_URI'])['path'] ?? null;
		$requestMethod = strtoupper($_SERVER['REQUEST_METHOD']);

		if ($requestUrl !== null) {
			foreach (self::$routes[$requestMethod] as $route) {
				if ((in_array($requestUrl, [$route['path'], $route['path'] . '/'])) || (strpos($route['path'], '*') && strpos($requestUrl, rtrim($route['path'], '/*')) !== false)) {
					call_user_func_array($route['function'], []);

					return 200;
				}
			}
		}

		return false;
	}
}
