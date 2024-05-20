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
	<?= PHP_EOL . \App\Legacy\StyleLoader::loadInline() ?>

	<!-- Scripts -->
	<script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
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

	<script defer src="https://cdn.jsdelivr.net/npm/leader-line-new@1.1.9/leader-line.min.js"></script>

	<?= \App\Legacy\ScriptLoader::loadFootInline() ?>
</body>

</html>