<?php

namespace LogicManager;

class AdminLogic {

	public static $listResultConfiguration;
	public static $listButtonConfiguration;
	public static $formAddFunction;
	public static $additionalFormAddFunction;
	public static $formUpdateFunction;
	public static $additionalFormUpdateFunction;

	/**
	 * Set methods
	 */
	public static function setListResultConfiguration(callable $function) {
		self::$listResultConfiguration = $function;

		return new static;
	}

	public static function setListButtonConfiguration(callable $function) {
		self::$listButtonConfiguration = $function;

		return new static;
	}

	public static function setFormAddFunction(callable $function) {
		self::$formAddFunction = $function;

		return new static;
	}

	public static function setAdditionalFormAddFunction(callable $function) {
		self::$additionalFormAddFunction = $function;

		return new static;
	}

	public static function setFormUpdateFunction(callable $function) {
		self::$formUpdateFunction = $function;

		return new static;
	}

	public static function setAdditionalFormUpdateFunction(callable $function) {
		self::$additionalFormUpdateFunction = $function;

		return new static;
	}

	/**
	 * Misc methods
	 */
	public static function executeListResultConfiguration(array $resultConfig, int $listFieldKey, array $listFieldData, array $databaseData) {
		return call_user_func(self::$listResultConfiguration, $resultConfig, $listFieldKey, $listFieldData, $databaseData);
	}

	public static function executeListButtonConfiguration(array $button, int $buttonKey, array $queryRow) {
		return call_user_func(self::$listButtonConfiguration, $button, $buttonKey, $queryRow);
	}

	public static function executeFormAddFunction(array $inputs) {
		return call_user_func(self::$formAddFunction, $inputs);
	}

	public static function executeAdditionalFormAddFunction(array $inputs, int $id) {
		return call_user_func(self::$additionalFormAddFunction, $inputs, $id);
	}

	public static function executeFormUpdateFunction(array $inputs, int $id) {
		return call_user_func(self::$formUpdateFunction, $inputs, $id);
	}

	public static function executeAdditionalFormUpdateFunction(array $inputs, int $id) {
		return call_user_func(self::$additionalFormUpdateFunction, $inputs, $id);
	}
}
