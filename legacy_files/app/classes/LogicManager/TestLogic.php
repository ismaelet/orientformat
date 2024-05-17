<?php

namespace LogicManager;

class TestLogic {

	public static $parameterCount;
	public static $testSubmitFunction;

	/**
	 * Set methods
	 */
	public static function setParameterCount(int $parameterCount) {
		self::$parameterCount = $parameterCount;

		return new static;
	}

	public static function setTestSubmitFunction(callable $function) {
		self::$testSubmitFunction = $function;

		return new static;
	}

	/**
	 * Misc methods
	 */
	public static function runTestSubmitFunction() {
		return call_user_func(self::$testSubmitFunction, (self::$parameterCount ?: ($_POST['result_count'] ?? 0)));
	}
}
