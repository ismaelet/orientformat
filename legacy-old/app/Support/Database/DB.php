<?php

/*
namespace App\Support\Database;

use App\Models\StdClass;
use App\Support\Traits\Singleton;
use Exception;

class DB {

	use Singleton;

	/**
	 * @param string the table to interact with
	 
	private static $table;

	/**
	 * @param array the stored parameters for the next query
	 
	private static $storedParamenters = [];

	/**
	 * @param array WHERE clauses of the next query
	 
	private static $where = [];

	/**
	 * @param int|array|bool stored response of the last query
	 
	private static $response;

	/**
	 * Execute a SQL query
	 * 
	 * @param string $sql the query to execute
	 * @param array $parameters
	 * @return object self
	 
	public function execute(string $sql, array $paramenters = []): self {
		$types = '';
		$bindParameters = [];

		// prepare the query
		$connection = ConnectionInterface::getInstance()->connection();

		$stmt = $connection->prepare($sql);

		if ($stmt === false) {
			die("Error preparing statement: " . $connection->error);
		}

		// prepare the parameters
		if (!empty($paramenters)) {
			foreach ($paramenters as $parameter) {
				switch (true) {
					case is_int($parameter):
						$types .= 'i';
						break;
					case is_float($parameter):
						$types .= 'd';
						break;
					case is_string($parameter):
						$types .= 's';
						break;
					default:
						$types .= 'b';
				}

				$bindParameters[] = $parameter;
			}

			$stmt->bind_param($types, ...$paramenters);
		}

		$result = $stmt->execute();

		// Check if the execution was successful
		if ($result === false) {
			die("Error executing statement: " . $stmt->error);
		}

		// Parse the response
		if (stripos($sql, 'SELECT') === 0 || stripos($sql, 'SHOW') === 0) {
			// If it's a SELECT or SHOW query, the response is an array with the selected rows or a FALSE if no rows where found
			$resultSet = $stmt->get_result();

			$response = $resultSet->fetch_all(MYSQLI_ASSOC) ?: false;

			$resultSet->close();
		} else if (stripos($sql, 'INSERT') === 0) {
			// If it's am INSERT queries, return the inserted ID
			$response = $connection->insert_id;
		} else {
			// If it's another type of query (UPDATE, DELETE) return the number of affected rows
			$response = $stmt->affected_rows;
		}

		$stmt->close();

		self::$response = $response;

		return $this;
	}

	/**
	 * Select only the first row
	 * 
	 * @param string $sql the query to execute
	 * @param array $parameters
	 * @return array | bool returns the first matching row or FALSE if no mathing row was found
	 
	public function first() {
		if (self::$response !== null) {
			return new StdClass(self::$response[0]);
		} else {
			$sql = "SELECT id FROM " . self::$table;

			if (self::$table) {

				if (self::$where) {
					$filters = implode(', ', array_map(function ($column) {
						return $column .= ' = ?';
					}, array_keys(self::$where)));

					$sql .= ' WHERE ' . $filters;
				}

				$paramenters = array_merge(array_values(self::$where), self::$storedParamenters);

				$response = self::execute($sql, $paramenters);

				self::cleanup();

				return $response ? new StdClass($response[0]) : null;
			}

			throw new Exception('Table not set for query: ' . $sql);
		}
	}

	/**
	 * Set the table to interact with
	 * 
	 * @return object self
	 
	public function table(string $table): self {
		self::$table = $table;

		return $this;
	}

	/**
	 * Restrict the interaction to specific rows
	 * 
	 * @return object self
	 
	public function where(string $column, $value): self {
		self::$where[$column] = $value;

		return $this;
	}

	/**
	 * Restrict the interaction to specific rows
	 * 
	 * @return int returns the affected rows count
	 
	public function update(array $paramentersToSet, bool $allowNoRestrictions = false): int {
		if (!self::$table) {
			throw new Exception('No table set to update');
		}

		if (!self::$where && !$allowNoRestrictions) {
			throw new Exception('Updating ' . self::$table . ' without restrictions');
		}

		$columsSql = implode(', ', array_map(function ($column) {
			return $column .= ' = ?';
		}, array_keys($paramentersToSet)));

		$sql = "UPDATE " . self::$table . " SET " . $columsSql . ' ' . self::$where;
		$paramenters = array_merge(array_values($paramentersToSet), self::$storedParamenters);

		self::cleanup();

		return self::execute($sql, $paramenters)->first()->affectedRows;
	}

	/**
	 * Clean the data relative to the current query
	 * 
	 * @return void
	 
	private static function cleanup(): void {
		self::$table = '';
		self::$where = [];
		self::$storedParamenters = [];
		self::$response = null;
	}
}
*/