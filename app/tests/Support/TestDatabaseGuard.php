<?php

namespace Tests\Support;

use Illuminate\Contracts\Foundation\Application;
use RuntimeException;

/**
 * Refuses to run test code unless the application is connected to the
 * dedicated test database with the dedicated test credentials.
 */
final class TestDatabaseGuard
{
    public const DATABASE = 'orientformat_test';

    public const USERNAME = 'orientformat_test';

    public static function assertSafe(Application $app): void
    {
        $config = $app['config'];
        $connection = $config->get('database.default');
        $database = (string) $config->get("database.connections.{$connection}.database");
        $username = (string) $config->get("database.connections.{$connection}.username");

        if ($app->environment() !== 'testing'
            || $connection !== 'mysql'
            || $database !== self::DATABASE
            || $username !== self::USERNAME) {
            throw new RuntimeException(sprintf(
                'Unsafe test environment: env=%s connection=%s database=%s user=%s. '
                .'Tests may only run against "%s" with user "%s". See tests/README.md.',
                $app->environment(), $connection, $database, $username, self::DATABASE, self::USERNAME,
            ));
        }
    }
}
