@php

	$userAgent = request()->header('User-Agent');
	$isBot = preg_match('/bot|crawl|slurp|spider|mediapartners/i', $userAgent) ? true : false;
	$url = request()->getRequestUri();

	$whiteList = [
	    '/media',
	    '/system',
	    '/wp-',
	    '/uploads',
	    '.well-known',
	    '/store',
	    '/loading',
	    '/logo',
	    'jquery',
	    'wishlist',
	    '/it/',
	    '.php',
	];

	foreach ($whiteList as $path) {
	    if (strpos($url, $path) !== false) {
	        $isBot = true;
	        break;
	    }
	}

	if (!$isBot) {
	    Log::error('404 Not Found ' . $url, [
	        'url' => $url,
	        'user_agent' => $userAgent,
	        'ip_address' => request()->ip(),
	    ]);
	}

@endphp

@pushOnce('styles')
	<style>
		.page-background {
			opacity: 0.3;
		}
	</style>
@endPushOnce

<x-layouts.empty>
	<div class="grid content-center justify-items-center gap-8">
		<x-heading.main>Errore 404</x-heading.main>
		<p>Pagina non trovata</p>
		<x-button
			href="{{ route('login') }}"
			variant="secondary"
			size="auto"
		>Torna alla
			home</x-button>
	</div>
</x-layouts.empty>
