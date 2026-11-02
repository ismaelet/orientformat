<?php

namespace App\Services;

use App\Legacy\Logic;
use App\Legacy\MiddlewareLoader;
use App\Legacy\ScriptLoader;
use App\Legacy\StyleLoader;
use App\Legacy\Viewer;
use Illuminate\Http\Response;
use Throwable;

class LegacyPageRenderer
{
    public function render(
        string $page,
        string $template = 'main',
        ?string $title = null,
        array $data = [],
        array $middlewares = ['public'],
    ): Response {
        $request = request();
        Logic::reset();
        ScriptLoader::reset();
        StyleLoader::reset();
        $request->attributes->set('legacy.page', $page);
        $request->attributes->set('legacy.template', $template);
        $request->attributes->set('legacy.title', $title);
        $request->attributes->set('legacy.location', $page);
        $request->attributes->set('legacy.data', $data);
        $initialBufferLevel = ob_get_level();

        ob_start();

        try {
            $middlewareLoader = MiddlewareLoader::getInstance();

            foreach ($middlewares as $middleware) {
                $middlewareLoader->run($middleware);
            }

            Logic::add($template, 'template');
            Logic::add($page, 'page');
            Logic::load();
            StyleLoader::addPageStyles($page);
            ScriptLoader::addPageScripts($page);

            $html = Viewer::render();
            $output = ob_get_clean();

            return response($output.$html);
        } catch (Throwable $e) {
            while (ob_get_level() > $initialBufferLevel) {
                ob_end_clean();
            }

            throw $e;
        }
    }
}
