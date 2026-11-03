<?php

/**
 * Seeds (or resets) the Playwright fixtures in the isolated test database.
 * Usage: php tests/Support/seed-e2e.php [reset]
 */

use Illuminate\Contracts\Console\Kernel;
use Tests\Support\ReviewFixture;
use Tests\Support\TestDatabaseGuard;

require __DIR__.'/../../vendor/autoload.php';

$app = require __DIR__.'/../../bootstrap/app.php';
$app->make(Kernel::class)->bootstrap();

TestDatabaseGuard::assertSafe($app);

if (($argv[1] ?? '') === 'reset') {
    ReviewFixture::reset();
} else {
    ReviewFixture::seed();
}
