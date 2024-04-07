<?php

class MiddlewareLoader {

	use Singleton;

	private static $middlewares = [];

	private function __construct() {
		$defaultMiddlewareLoader = [
			'public' => function () {
				$public = !Config::getInstance()->hasDatabase ?: DB::find('value FROM config WHERE name = ?', ['public']);

				if (!$public && !admin()) {
					redirect('/offline');
				}
			},

			'not-public' => function () {
				$public = !Config::getInstance()->hasDatabase ?: DB::find('value FROM config WHERE name = ?', ['public']);

				if ($public) {
					redirect('/');
				}
			},

			'maintenance' => function () {
				redirect('/maintenance');
			},

			'logged' => function () {
				if (!logged()) {
					redirect('/login');
				}
			},

			'not-logged' => function () {
				$config = Config::getInstance();

				if (!$config->hasDatabase || logged()) {
					redirect($config->loggedRedirectUrl);
				}
			},

			'admin' => function () {
				if (!admin()) {
					redirect('/login');
				}
			},

			'not-admin' => function () {
				if (admin()) {
					redirect(Config::getInstance()->loggedRedirectUrl);
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
