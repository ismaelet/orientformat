<?php

namespace App\Legacy;

class Query_Result {

	public $res = false;
	public $num_rows = 0;

	function __construct($stmt) {

		$this->res = $stmt->res;
		$this->num_rows = $stmt->num_rows;
	}

	//fetch rows
	function fetch_assoc() {

		if ($this->res) {

			$row = array_shift($this->res);

			return $row;
		} else return false;
	}
}
