<?php

namespace App\Legacy;

use App\Services\LegacyPageRenderer;

class LegacyRoute
{
    private static $routes = [];

    public static function add($paths, $function)
    {
        $paths = (array) $paths;

        foreach ($paths as $path) {
            self::$routes[] = [
                'path' => CLIENT_ROOT.$path,
                'function' => $function,
            ];
        }
    }

    public static function run()
    {
        $path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

        if ($path !== null && $path !== false) {
            foreach (self::$routes as $route) {
                if (
                    in_array($path, [$route['path'], $route['path'].'/']) ||
                    (
                        str_contains($route['path'], '*') &&
                        str_contains($path, rtrim($route['path'], '/*'))
                    )
                ) {
                    return call_user_func_array($route['function'], [$path]);
                }
            }
        }

        // Error 404
        return app(LegacyPageRenderer::class)->render(
            page: 'errors/404',
            template: 'void',
            title: __('Error 404'),
            middlewares: [],
        );
    }
}
