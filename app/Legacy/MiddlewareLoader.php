<?php

namespace App\Legacy;

class MiddlewareLoader {

	use Singleton;

	private static $middlewares = [];

	private function __construct() {
		$defaultMiddlewareLoader = [
			'public' => function () {
				// dd('public');
				$public = !\App\Legacy\LegacyConfig::getInstance()->hasDatabase ?: \App\Legacy\LegacyDB::find('value FROM config WHERE name = ?', ['public']);

				if (!$public) {
					redirect_old('/offline');
				}
			},

			'not-public' => function () {
				// dd('not-public');
				$public = !\App\Legacy\LegacyConfig::getInstance()->hasDatabase ?: \App\Legacy\LegacyDB::find('value FROM config WHERE name = ?', ['public']);

				if ($public) {
					redirect_old('/');
				}
			},

			'maintenance' => function () {
				// dd('maintenance');
				redirect_old('/maintenance');
			},

			'logged' => function () {
				// dd('logged');
				if (!logged()) {
					redirect_old('/login');
				}
			},

			'not-logged' => function () {
				$config = \App\Legacy\LegacyConfig::getInstance();

				if (!$config->hasDatabase || logged()) {
					redirect_old('/');
				}
			},
		];

		foreach ($defaultMiddlewareLoader as $middlewareName => $middlewareFunction) {
			self::add($middlewareName, $middlewareFunction);
		}
	}

	public function add($middlewareName, $middlewareFunction) {
		self::$middlewares[$middlewareName] = $middlewareFunction;

		return $this;
	}

	public function run($middlewareName) {
		$middlewareFunction = self::$middlewares[$middlewareName] ?? null;

		if ($middlewareFunction) {
			$middlewareFunction();
		} else {
			exit('Access denied: ' . $middlewareName);
		}
	}
}
