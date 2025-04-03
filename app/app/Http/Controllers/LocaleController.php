<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;

class LocaleController extends Controller {

	/**
	 * Switch the application locale.
	 * 
	 * @param string $local
	 * @return \Illuminate\Http\RedirectResponse
	 */
	public function switchLocale(string $locale): RedirectResponse {
		if (array_key_exists($locale, config('app.locales'))) {
			Session::put('locale', $locale);
			setcookie('locale', $locale, time() + (86400 * 30), '/');
		}

		return redirect()->back();
	}
}
