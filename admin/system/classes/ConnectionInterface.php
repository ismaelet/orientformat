<?php

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

	use DynamicProperties;
	use Singleton;

	private const LOCAL_ADDRESSES = ['127.0.0.1', '::1'];
	private const LOCAL_DATA_PREFIX = 'local';
	private const TEST_DATA_PREFIX = 'test';
	private const LIVE_DATA_PREFIX = 'live';

	private static $connection;
	private static $hostname;
	private static $database;
	private static $username;
	private static $password;

	/**
	 * Magic methods
	 */
	private function __construct() {
		$config =  Config::getInstance();
		$currentServerAddress = $_SERVER['REMOTE_ADDR'];
		$liveServerAddress = $config->serverAddress;

		switch (true) {
			case in_array($currentServerAddress, self::LOCAL_ADDRESSES):
				$dataPrefix = self::LOCAL_DATA_PREFIX;
				break;

			case $liveServerAddress && $currentServerAddress != $liveServerAddress:
				$dataPrefix = self::TEST_DATA_PREFIX;
				break;

			default:
				$dataPrefix = self::LIVE_DATA_PREFIX;
		}

		self::$hostname = $config->{$dataPrefix . 'DatabaseHostname'};
		self::$database = $config->{$dataPrefix . 'DatabaseDatabase'};
		self::$username = $config->{$dataPrefix . 'DatabaseUsername'};
		self::$password = $config->{$dataPrefix . 'DatabasePassword'};

		try {
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
}
