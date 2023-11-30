<?php

namespace app\Http;

use Singleton;

class Request {

	use Singleton;

	public static function method() {
		return $_SERVER['REQUEST_METHOD'] ?: 'GET';
	}
}
