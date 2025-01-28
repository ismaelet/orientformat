<?php

namespace App\Support\Database;

class Blueprint {

	private $currentColumn;
	private $columns = [];
	private $toDrop = [];

	function __construct() {
	}

	/**
	 * Add the index
	 */
	public function id(): self {
		$this->columns['id'] = 'id INT(11) AUTO_INCREMENT PRIMARY KEY';

		$this->currentColumn = 'id';

		return $this;
	}

	/**
	 * Add an integer column
	 * 
	 * @return object self
	 */
	public function int(string $column): self {
		$this->columns[$column] = $column . ' INT(11)';

		$this->currentColumn = $column;

		return $this;
	}

	/**
	 * Add an integer column
	 * 
	 * @return object self
	 */
	public function boolean(string $column): self {
		$this->columns[$column] = $column . ' TINYINT(1) DEFAULT 0';

		$this->currentColumn = $column;

		return $this;
	}

	/**
	 * Add a string column
	 * 
	 * @return object self
	 */
	public function string(string $column): self {
		$this->columns[$column] = $column . ' VARCHAR(255)';

		$this->currentColumn = $column;

		return $this;
	}

	/**
	 * Add a timestamp column
	 * 
	 * @return object self
	 */
	public function timestamp(): self {
		$this->columns['time_added'] = 'time_added TIMESTAMP DEFAULT CURRENT_TIMESTAMP';

		$this->currentColumn = 'time_added';

		return $this;
	}

	/**
	 * Add a default value
	 * 
	 * @param mixed $defaultValue
	 * @return object self
	 */
	public function default($defaultValue): self {
		$sql = explode(' DEFAULT ', $this->columns[$this->currentColumn])[0];

		$this->columns[$this->currentColumn] = $sql . ' DEFAULT ' . $defaultValue;

		return $this;
	}

	/**
	 * Edit the maximum length
	 * 
	 * @param int $length
	 * @return object self
	 */
	public function length(int $length): self {
		$pattern = '/\((\d+)\)/';

		preg_match($pattern, $this->columns[$this->currentColumn], $matches);

		if (!empty($matches)) {
			$this->columns[$this->currentColumn] = preg_replace($pattern, "($length)", $this->columns[$this->currentColumn]);
		}

		return $this;
	}

	/**
	 * Add a column to the drop list
	 * 
	 * @param string $column
	 * @return object self
	 */
	public function drop(string $column): self {
		$this->toDrop[] = $column;

		$this->currentColumn = $column;

		return $this;
	}

	/**
	 * Return the stored columns
	 * 
	 * @return array the list of the columns to add as ['columnName' => 'columnSql', ...]
	 */
	public function columns(): array {
		return $this->columns;
	}

	/**
	 * Return the columns to drop
	 * 
	 * @return array the list of the columns to drop
	 */
	public function toDrop(): array {
		return $this->toDrop;
	}
}
