<?php

namespace App\Legacy\Exceptions;

use RuntimeException;

class LegacyRedirectException extends RuntimeException
{
    public function __construct(
        public readonly string $url
    ) {
        parent::__construct('Legacy redirect: '.$url);
    }
}
