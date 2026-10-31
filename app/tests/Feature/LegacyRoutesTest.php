<?php

use App\Http\Controllers\HelpController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LegacyController;
use App\Http\Controllers\ReviewController;
use App\Legacy\Exceptions\LegacyRedirectException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

test('legacy pages resolve through explicit Laravel routes', function (string $path, string $action): void {
    foreach (['GET', 'HEAD', 'POST', 'PUT', 'PATCH', 'DELETE', 'OPTIONS'] as $method) {
        if ($path === '/review' && $method === 'POST') {
            continue;
        }

        $route = Route::getRoutes()->match(Request::create($path, $method));

        expect($route->getActionName())->toBe(LegacyController::class.'@'.$action);
        expect($route->uri())->toBe(ltrim($path, '/'));
    }
})->with([
    ['/wait', 'wait'],
    ['/add-email', 'addEmail'],
    ['/tutorial', 'tutorial'],
    ['/interest', 'interest'],
    ['/review', 'review'],
    ['/teacher/know-more', 'knowMore'],
    ['/teacher/paths', 'paths'],
    ['/read', 'read'],
]);

test('modern routes retain priority over legacy aliases', function (string $method, string $path, string $action): void {
    $route = Route::getRoutes()->match(Request::create($path, $method));

    expect($route->getActionName())->toBe($action);
})->with([
    ['GET', '/', HomeController::class.'@index'],
    ['GET', '/help', HelpController::class.'@index'],
    ['POST', '/review', ReviewController::class.'@store'],
    ['GET', '/review/2', ReviewController::class.'@show'],
]);

test('remaining system endpoints have bounded Laravel routes', function (string $path, string $name): void {
    $route = Route::getRoutes()->match(Request::create($path, 'POST'));

    expect($route->getActionName())->toBe(LegacyController::class);
    expect($route->getName())->toBe($name);
})->with([
    ['/ajax/grade-list', 'legacy.ajax'],
    ['/api-old/call-function/Some/function', 'legacy.api.call-function'],
    ['/api-old/search-table/students', 'legacy.api.search-table'],
    ['/api-old/get-class-properties/Legacy/Activity/Test', 'legacy.api.get-class-properties'],
    ['/api-old/call-class-method/Legacy/Activity/Test', 'legacy.api.call-class-method'],
    ['/favicon.ico', 'legacy.favicon'],
]);

test('unknown URLs return Laravel not found responses', function (): void {
    foreach (['/unknown-legacy-page', '/api-old/unknown-operation/example'] as $path) {
        expect(fn () => Route::getRoutes()->match(Request::create($path)))
            ->toThrow(NotFoundHttpException::class);
    }
});

test('legacy execution captures output and cleans its buffers on redirects', function (): void {
    $controller = new class extends LegacyController
    {
        protected function initializeLegacy(): void {}

        public function run(Closure $action): Response
        {
            return $this->execute($action);
        }
    };

    $level = ob_get_level();
    $response = $controller->run(function () {
        echo 'Legacy output';
    });

    expect($response->getContent())->toBe('Legacy output');
    expect(ob_get_level())->toBe($level);

    $response = $controller->run(function () {
        ob_start();
        echo 'Discarded output';
        throw new LegacyRedirectException('/login');
    });

    expect($response->isRedirect())->toBeTrue();
    expect($response->headers->get('Location'))->toBe(url('/login'));
    expect(ob_get_level())->toBe($level);
});
