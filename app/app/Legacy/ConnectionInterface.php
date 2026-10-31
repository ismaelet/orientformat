<?php

namespace App\Legacy;

use Exception;
use Illuminate\Support\Facades\DB;
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
class ConnectionInterface
{
    use DynamicProperties;
    use Singleton;

    private static $connection;

    private static $hostname;

    private static $database;

    private static $username;

    private static $password;

    public static $timeOpen;

    public static $queryCount = 0;

    /**
     * Magic methods
     */
    private function __construct()
    {
        // Resolve Laravel's connection so DATABASE_URL is respected as well.
        $config = DB::connection()->getConfig();
        self::$hostname = $config['host'];
        self::$database = $config['database'];
        self::$username = $config['username'];
        self::$password = $config['password'];

        try {
            self::$timeOpen = microtime(true);
            $connection = new mysqli(self::$hostname, self::$username, self::$password, self::$database, (int) ($config['port'] ?? 3306), $config['unix_socket'] ?? null);
            $connection->query('SET NAMES utf8');

            self::$connection = $connection;
        } catch (Exception $e) {
            echo $error = $e->getMessage();

            error_log('Connection error: '.$error.PHP_EOL.'On page: '.$_SERVER['REQUEST_URI']);
        }
    }

    /**
     * Get methods
     */
    private function getConnection()
    {
        return self::$connection;
    }

    private function getHostname()
    {
        return self::$hostname;
    }

    private function getDatabase()
    {
        return self::$database;
    }

    private function getUsername()
    {
        return self::$username;
    }

    private function getPassword()
    {
        return self::$password;
    }

    /**
     * Singleton methods
     */
    public function close() {}
}
