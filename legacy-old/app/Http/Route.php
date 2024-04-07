<?php

namespace app\Http;

use Singleton;

class Route {

	use Singleton;

	public static function get(callable $function) {
		if (Request::method() == 'GET') {
			$function();
		}
	}

	public static function post(callable $function) {
		if (Request::method() == 'POST') {
			$function();
		}
	}
}
