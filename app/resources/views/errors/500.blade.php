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
	<div class="grid content-center justify-items-center gap-8 text-center">
		<div class="">
			<x-heading.main>Errore 500</x-heading.main>
		</div>

		<p class="max-w-160">Siamo spiacenti, ma si è verificato un errore interno del server. I tecnici sono appena stati
			avvisati e stanno già
			lavorando per risolvere il problema. Se vuoi comunque contattare il supporto, puoi farlo tramite il nostro <a
				class="text-link"
				href="{{ route('help.ticket.open') }}"
			>formulario di contatto</a>.
		</p>

		<x-button
			href="{{ route('login') }}"
			variant="secondary"
			size="auto"
		>Torna alla
			home</x-button>
	</div>
</x-layouts.empty>
