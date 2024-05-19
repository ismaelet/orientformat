<?php

namespace Legacy\System\Classes;

use Exception;
use mysqli;

/**
 * Connection Interface class
 * 
 * @property object connection
 * @property string hostname
 * @property string database
 * @property string username
 * @property string password
 */
class ConnectionInterface {

	use \System\Traits\DynamicProperties;
	use \System\Traits\Singleton;

	private const DEVELOPEMENT_DATA_PREFIX = 'local';
	private const PRODUCTION_DATA_PREFIX = 'live';

	private static $connection;
	private static $hostname;
	private static $database;
	private static $username;
	private static $password;
	private static $envirnoment;
	public static $timeOpen;
	public static $queryCount = 0;

	/**
	 * Magic methods
	 */
	private function __construct() {
		$config = \Legacy\System\Classes\LegacyConfig::getInstance();
		$currentServerAddress = $_SERVER['REMOTE_ADDR'];
		$liveServerAddress = $config->serverAddress;

		if ($currentServerAddress == $liveServerAddress) {
			$dataPrefix = self::PRODUCTION_DATA_PREFIX;
			self::$envirnoment = 'production';
		} else {
			$dataPrefix = self::DEVELOPEMENT_DATA_PREFIX;
			self::$envirnoment = 'developement';
		}

		self::$hostname = $config->{$dataPrefix . 'DatabaseHostname'};
		self::$database = $config->{$dataPrefix . 'DatabaseDatabase'};
		self::$username = $config->{$dataPrefix . 'DatabaseUsername'};
		self::$password = $config->{$dataPrefix . 'DatabasePassword'};

		try {
			self::$timeOpen = microtime(true);
			$connection = new mysqli(self::$hostname, self::$username, self::$password, self::$database);
			$connection->query('SET NAMES utf8');

			self::$connection = $connection;
		} catch (Exception $e) {
			echo $error = $e->getMessage();

			error_log('Connection error: ' . $error . PHP_EOL . 'On page: ' . $_SERVER['REQUEST_URI']);
		}
	}

	/**
	 * Get methods
	 */
	private function getConnection() {
		return self::$connection;
	}

	private function getHostname() {
		return self::$hostname;
	}

	private function getDatabase() {
		return self::$database;
	}

	private function getUsername() {
		return self::$username;
	}

	private function getPassword() {
		return self::$password;
	}

	/**
	 * Singleton methods
	 */
	public function close() {
		// $userId = userId();

		// self::$connection->close();

		// $intervalOpen = round(microtime(true) - self::$timeOpen, 3) * 1000;

		// $prefix = '';

		// if ($intervalOpen > 1000) {
		// 	$prefix = '!!! ';
		// } else if ($intervalOpen > 100) {
		// 	// $prefix = '!! ';
		// }

		// $message = $prefix . date('Y-m-d H:i:s') . ' Richiesta di ' . $intervalOpen . 'ms effettuata in ' . $_SERVER['REQUEST_URI'] . ($userId ? ' dall\'utente ' . $userId : null) . PHP_EOL;

		// if (self::$envirnoment == 'developement' || studentId() && studentId() == 4719) {
		// 	echo $message . '<br>';
		// 	echo 'Numero di queries: ' . self::$queryCount;
		// }

		// // file_put_contents(server_path('/logs/connection.log'), $message, FILE_APPEND);
	}
}
