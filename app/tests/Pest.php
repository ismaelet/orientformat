<?php

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\Support\BaselineFixture;
use Tests\TestCase;

pest()
    ->extend(TestCase::class)
    ->use(DatabaseTransactions::class)
    ->in('Feature');

// Reference data the app expects, replacing records formerly read from the dev database.
pest()->beforeEach(fn () => BaselineFixture::seed())->in('Feature');
