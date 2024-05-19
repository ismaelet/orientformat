<!doctype html>
<html data-theme="light" data-client-root="/orientamento" data-school-group="<?= is_student() ? (auth()->user()->isHighschoolStudent() ? 'highschool' : 'middleschool') : 'none' ?>">

<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1.0">
	<meta name="description" content="<?= \App\Legacy\LegacyView::getDescription() ?>">
	<title><?= \App\Legacy\LegacyView::getTabTitle() ?></title>
	<meta property="og:description" content="<?= \App\Legacy\LegacyView::getDescription() ?>">
	<link rel="icon" href="<?= asset('favicon.ico') ?>">

	<!-- Styles -->
	<link href="<?= asset('legacy.css') ?>" rel="stylesheet">
	<link href="<?= asset('main.css') ?>" rel="stylesheet">
	<?= PHP_EOL . \App\Legacy\StyleLoader::load() ?>

	<!-- Scripts -->
	<script src="https://code.jquery.com/jquery-3.7.1.slim.min.js" integrity="sha256-kmHvs0B+OpCW5GVHUNjv9rOmY0IvSIRcf7zGUDTDQM8=" crossorigin="anonymous"></script>
	<script src="<?= asset('legacy.js') ?>"></script>
	<script src="<?= asset('main.js') ?>"></script>
	<?= PHP_EOL . \App\Legacy\ScriptLoader::load() ?>

	<!-- Google tag (gtag.js) -->
	<?php if (env('APP_ENV') == 'production') { ?>
		<script async src="https://www.googletagmanager.com/gtag/js?id=G-8WZ7THPZ57"></script>
		<script>
			window.dataLayer = window.dataLayer || [];

			function gtag() {
				dataLayer.push(arguments);
			}
			gtag('js', new Date());

			gtag('config', 'G-8WZ7THPZ57');
		</script>
	<?php } ?>
</head>

<body>
	{% place body %}

	<?php if (\App\Legacy\LegacyConfig::getInstance()->cookiesWarning && !isset($_COOKIE['cookies-warning'])) { ?>

		<div class="cookies-warning">
			<h3 class="cookies-warning_title">Avviso cookies</h3>
			<div class="cookies-warning_body">
				<p class="cookies-warning_text">
					Questo sito fa uso di cookie per migliorare l’esperienza di navigazione degli utenti e per raccogliere informazioni sull’utilizzo del sito stesso. Utilizziamo sia cookie tecnici sia cookie di parti terze per inviare messaggi promozionali sulla base dei comportamenti degli utenti. Può conoscere i dettagli consultando la nostra privacy policy <a class="cookies-warning_link" href="<?= client_url('/privacy') ?>">qui</a>. Proseguendo nella navigazione si accetta l’uso dei cookie; in caso contrario è possibile abbandonare il sito.
				</p>
				<div class="cookies-warning_footer">
					<div class="cookies-warning_pbtn cookies-warning_btn pbtn js-accept-cookies-warning">Accetta</div>
					<!-- <div class="cookies-warning_sbtn cookies-warning_btn sbtn">Rifiuta</div> -->
				</div>
			</div>
		</div>

	<?php } ?>

	<script defer src="https://cdn.jsdelivr.net/npm/leader-line-new@1.1.9/leader-line.min.js"></script>
</body>

</html>