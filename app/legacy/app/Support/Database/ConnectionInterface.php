<?php

namespace App\Support\Database;

use Exception;
use mysqli;

class ConnectionInterface
{
    use \System\Traits\Singleton;

    /**
     * The connection data
     */
    private static $connection;

    private static $hostname;

    private static $database;

    private static $username;

    private static $password;

    /**
     * Create the instance
     */
    private function __construct()
    {
        self::$hostname = config('database.host');
        self::$database = config('database.database');
        self::$username = config('database.username');
        self::$password = config('database.password');

        try {
            $connection = new mysqli(self::$hostname, self::$username, self::$password, self::$database);
            $connection->query('SET NAMES utf8');

            self::$connection = $connection;
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }

    /**
     * Get the MySQLi connection object
     *
     * @return object retutns the mysqli connection
     */
    public function connection(): object
    {
        return self::$connection;
    }
}
