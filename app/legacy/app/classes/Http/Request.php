<?php

namespace Legacy\Http;

use System\Traits\Singleton;

class Request
{
    use Singleton;

    public static function method()
    {
        return $_SERVER['REQUEST_METHOD'] ?: 'GET';
    }
}
