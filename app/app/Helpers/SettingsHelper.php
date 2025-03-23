<?php

namespace App\Helpers;

class SettingsHelper {

	/**
	 * Get the app color scheme
	 * 
	 * @return string
	 */
	public static function getColorScheme(): string {
		$defaultColorScheme = config('custom.meta_data.default_color_scheme') ?: 'light';
		$appHasDynamicColorScheme = config('custom.meta_data.dynamic_color_scheme') == true;
		$cookieColorScheme = isset($_COOKIE['color-scheme']) && in_array($_COOKIE['color-scheme'], ['light', 'dark'])
			? $_COOKIE['color-scheme']
			: false;

		return $appHasDynamicColorScheme && $cookieColorScheme
			? $cookieColorScheme
			: $defaultColorScheme;
	}
}
