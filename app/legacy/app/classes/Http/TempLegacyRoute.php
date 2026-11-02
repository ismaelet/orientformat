<?php

namespace Legacy\Http;

use System\Traits\Singleton;

class TempLegacyRoute
{
    use Singleton;

    public static function get(callable $function)
    {
        if (Request::method() == 'GET') {
            $function();
        }
    }

    public static function post(callable $function)
    {
        if (Request::method() == 'POST') {
            $function();
        }
    }
}
