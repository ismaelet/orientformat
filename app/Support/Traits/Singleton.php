<?php

namespace App\Support\Traits;

trait Singleton {

	/**
	 * The instanced static class
	 */
	private static $instance;

	/**
	 * Return the instanced static class
	 */
	public static function getInstance(): Object {
		if (!isset(self::$instance)) {
			self::$instance = new self();
		}

		return self::$instance;
	}
}
