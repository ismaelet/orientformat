<?php

use Illuminate\Contracts\Console\Kernel;
use Tests\Support\TemperamentoFixture;
use Tests\Support\TestDatabaseGuard;

require __DIR__.'/../../vendor/autoload.php';

$app = require __DIR__.'/../../bootstrap/app.php';
$app->make(Kernel::class)->bootstrap();
TestDatabaseGuard::assertSafe($app);

echo json_encode(($argv[1] ?? 'seed') === 'results'
    ? TemperamentoFixture::results()
    : TemperamentoFixture::seed(), JSON_THROW_ON_ERROR);
