<?php

namespace App\Providers;

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

		// Fix livewire endpoints
		Livewire::setScriptRoute(function ($handle) {
			return Route::get('/' . env('APP_SUBDOMAIN') . '/livewire/livewire.js', $handle);
		});

		Livewire::setUpdateRoute(function ($handle) {
			return Route::post('/' . env('APP_SUBDOMAIN') . '/livewire/update', $handle);
		});

		// Fix filament favicon
		Filament::serving(function () {
			Filament::registerRenderHook(
				'panels::head.start',
				fn() => '<link rel="icon" type="image/png" href="' . asset('favicon.ico') . '">'
			);
		});
	}
}
