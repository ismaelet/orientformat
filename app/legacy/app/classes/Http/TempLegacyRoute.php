<?php

namespace Legacy\Http;



class TempLegacyRoute {

	use \System\Traits\Singleton;

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
