<?php

/**
 * Front controller for the Playwright server. It serves the application with
 * an alternative public path (no Vite "hot" file, so built assets are used) and
 * refuses to handle requests unless the isolated test database is configured.
 */

use Illuminate\Contracts\Console\Kernel;
use Illuminate\Http\Request;
use Tests\Support\TestDatabaseGuard;

define('LARAVEL_START', microtime(true));

require __DIR__.'/../../vendor/autoload.php';

$app = require_once __DIR__.'/../../bootstrap/app.php';
$app->usePublicPath($_SERVER['DOCUMENT_ROOT']);
$app->make(Kernel::class)->bootstrap();

TestDatabaseGuard::assertSafe($app);

$app->handleRequest(Request::capture());
