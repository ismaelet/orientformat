<?php

use App\Http\Middleware\Administrator;
use App\Http\Middleware\Locale;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Support\Facades\Route;
use Sentry\Laravel\Integration;

return Application::configure(basePath: dirname(__DIR__))
	->withRouting(
		web: __DIR__ . '/../routes/web.php',
		commands: __DIR__ . '/../routes/console.php',
		health: '/up',
		then: function () {
			Route::middleware(['web', Administrator::class])
				->prefix(env('APP_SUBDOMAIN') . '/admin')
				->name('admin.')
				->group(base_path('routes/web-admin.php'));

			Route::middleware('web')
				->prefix(env('APP_SUBDOMAIN'))
				->group(base_path('routes/web-auth.php'));

			Route::middleware('web')
				->prefix(env('APP_SUBDOMAIN'))
				->group(base_path('routes/web.php'));

			Route::prefix(env('APP_SUBDOMAIN') . '/api')
				->middleware('api')
				->group(base_path('routes/api.php'));

			Route::middleware('web')
				->group(base_path('routes/web-legacy.php'));
		}
	)
	->withMiddleware(function (Middleware $middleware) {
		$middleware->validateCsrfTokens(except: [
			'*',
		]);
		$middleware->append(Locale::class);
	})
	->withExceptions(function (Exceptions $exceptions) {
		Integration::handles($exceptions);
	})->create();
