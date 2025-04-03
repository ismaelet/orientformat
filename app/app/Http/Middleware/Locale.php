<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;

class Locale {

	/**
	 * Handle an incoming request.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  \Closure  $next
	 * @return mixed
	 */
	public function handle($request, Closure $next) {
		$locale = Session::get('locale');

		if (!$locale) {
			$locale = $_COOKIE['locale'] ?? null;
		}

		if (!$locale || !array_key_exists($locale, config('app.locales'))) {
			$locale = config('app.fallback_locale');
		}

		App::setLocale($locale);

		return $next($request);
	}
}
