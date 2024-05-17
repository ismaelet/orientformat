<?php

namespace System\Classes;

/**
 * Access the system configuration
 * 
 * @property bool hasDatabase 
 * 
 * @property string title
 * @property string websiteUrl
 * 
 * @property string logoFileName
 * @property string logo
 * @property string clientLogo
 * @property string severLogo
 * @property string absoluteLogo
 * @property string emailLogo
 * @property string themeColor
 */

class ConfigOld {

	use \System\Traits\Singleton;

	private const CONFIG_FILE = 'app/config/config.php';
	private const DEFAULT_THEME = 'light';

	private static $values = [];

	/**
	 * Magic methods
	 */
	private function __construct() {
		$configSettings = require_once base_path() . '/legacy/' . self::CONFIG_FILE;

		foreach ($configSettings as $key => $value) {
			self::$values[$key] = $value;
		}
	}

	function __get($property) {
		$method = 'get' . ucfirst($property);
		$property = camel_case_to_kebab_case($property);

		if (array_key_exists($property, self::$values)) {
			return self::$values[$property];
		} else if (method_exists($this, $method)) {
			return self::$values[$property] = $this->$method();
		} else {
			return self::$values[$property] = null;
		}
	}

	/**
	 * Get methods
	 */
	private function getHasDatabase() {
		return true;
	}

	private function getDefaultLanguage() {
		return key($this->languages);
	}

	private function getLogoFileName() {
		return 'logo-preview.jpg';
	}

	private function getLogo() {
		return LOGO_DIR . $this->logoFileName;
	}

	private function getClientLogo() {
		if (file_exists(server_path($this->logo))) {
			return client_path($this->logo);
		} else if (file_exists(server_path($this->logo))) {
			return public_client_path($this->logo);
		} else {
			return null;
		}
	}

	private function getSeverLogo() {
		if (file_exists($file = server_path($this->logo))) {
			return $file;
		} else if (file_exists($file = server_path($this->logo))) {
			return $file;
		} else {
			return null;
		}
	}

	private function getAbsoluteLogo() {
		return $this->websiteUrl . $this->logoImage;
	}

	private function getEmailLogo() {
		if (file_exists(server_path($file = LOGO_DIR . 'logo-email.png'))) {
			return $this->websiteUrl . public_client_url($file);
		} else {
			return $this->absoluteLogo;
		}
	}

	private function getThemeColor() {
		return self::DEFAULT_THEME;
	}

	private function getCookiesWarning() {
		return false;
	}

	private function getLoggedRedirectUrl() {
		return '/';
	}

	private function getWebsiteUrl() {
		if ($this->domain) {
			return 'https://' . $this->domain;
		} else {
			$https = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? 'https' : 'http';

			return $https . '://' . $_SERVER['HTTP_HOST'] . CLIENT_ROOT;
		}
	}
}
