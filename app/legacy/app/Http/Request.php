<?php

namespace app\Http;



class Request {

	use \System\Traits\Singleton;

	public static function method() {
		return $_SERVER['REQUEST_METHOD'] ?: 'GET';
	}
}
