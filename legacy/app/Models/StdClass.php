<?php

namespace LegacyModels;

class StdClass {

	/**
	 * @property array
	 */
	private $databaseData = [];

	/**
	 * @property int|bool|null
	 */
	public $value;

	/**
	 * Construct
	 */
	public function __construct($parameters) {
		$this->initialize($parameters);
	}

	public function initialize($parameters) {
		switch (true) {
			case is_array($parameters):
				$this->databaseData = $parameters;
				return $this;

			case is_bool($parameters) || is_null($parameters):
				$this->value = $parameters;
				return $this;
		}
	}
}
