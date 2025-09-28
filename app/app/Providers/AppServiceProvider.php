<?php

namespace App\Providers;

use App\Http\Responses\LogoutResponse;
use Filament\Auth\Http\Responses\Contracts\LogoutResponse as ContractsLogoutResponse;
use Filament\Facades\Filament;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Vite;
use Illuminate\Support\ServiceProvider;
use Livewire\Livewire;

class AppServiceProvider extends ServiceProvider {

	/**
	 * Register any application services.
	 */
	public function register(): void {
		$files = glob(app_path('Helpers') . "/*.php");

		foreach ($files as $key => $file) {
			require_once $file;
		}

		$this->app->bind(ContractsLogoutResponse::class, LogoutResponse::class);
	}

	/**
	 * Bootstrap any application services.
	 */
	public function boot(): void {
		// Register Vite image helper
		Vite::macro('image', fn(string $asset) => $this->asset("resources/images/{$asset}"));

		// Prevent lazy loading in non-production environments
		Model::preventLazyLoading(! app()->isProduction());

		// Force base URL
		URL::forceRootUrl(config('app.url'));

		// If using HTTPS, also force it
		if (app()->isProduction()) {
			URL::forceScheme('https');
		}

		// Extract subdir from APP_URL (e.g. "/orientamento")
		$prefix = 'orientamento';

		Livewire::setUpdateRoute(function ($handle) use ($prefix) {
			return Route::post($prefix . '/livewire/updatelaskdjlaksjdj', $handle)
				->name('livewire.update');
		});

		if (config('app.debug')) {
			Livewire::setScriptRoute(function ($handle) use ($prefix) {
				return Route::get($prefix . '/livewire/livewire.js', $handle)
					->name('livewire.js');
			});
		} else {
			Livewire::setScriptRoute(function ($handle) use ($prefix) {
				return Route::get($prefix . '/livewire/livewire.min.js', $handle)
					->name('livewire.js');
			});
		}


		// Fix filament favicon
		Filament::serving(function () {
			Filament::registerRenderHook(
				'panels::head.start',
				fn() => '<link rel="icon" type="image/png" href="' . asset('favicon.ico') . '">'
			);
		});
	}
}
