<?php

namespace App\Legacy;

use Illuminate\Support\Facades\DB;

class MiddlewareLoader
{
    use Singleton;

    private static $middlewares = [];

    private function __construct()
    {
        $defaultMiddlewareLoader = [
            'public' => function () {
                // dd('public');
                $public = ! LegacyConfig::getInstance()->hasDatabase ?: DB::table('config')->where('name', 'public')->value('value');

                if (! $public) {
                    redirect_old('/offline');
                }
            },

            'not-public' => function () {
                // dd('not-public');
                $public = ! LegacyConfig::getInstance()->hasDatabase ?: DB::table('config')->where('name', 'public')->value('value');

                if ($public) {
                    redirect_old('/');
                }
            },

            'logged' => function () {
                if (! logged()) {
                    redirect_old('/login');
                }
            },

            'not-logged' => function () {
                $config = LegacyConfig::getInstance();

                if (! $config->hasDatabase || logged()) {
                    redirect_old('/');
                }
            },
        ];

        foreach ($defaultMiddlewareLoader as $middlewareName => $middlewareFunction) {
            self::add($middlewareName, $middlewareFunction);
        }
    }

    public function add($middlewareName, $middlewareFunction)
    {
        self::$middlewares[$middlewareName] = $middlewareFunction;

        return $this;
    }

    public function run($middlewareName)
    {
        $middlewareFunction = self::$middlewares[$middlewareName] ?? null;

        if ($middlewareFunction) {
            $middlewareFunction();
        } else {
            exit('Access denied: '.$middlewareName);
        }
    }
}
