<!doctype html>
<html data-theme="<?= $_SESSION['theme-color'] ?>" data-client-root="<?= CLIENT_ROOT ?>">

<head>
	<?= PHP_EOL . ViewOld::getInstance()->renderHeadContent() . PHP_EOL . PHP_EOL ?>

	<!-- Google tag (gtag.js) -->
	<script async src="https://www.googletagmanager.com/gtag/js?id=G-8WZ7THPZ57"></script>
	<script>
		window.dataLayer = window.dataLayer || [];

		function gtag() {
			dataLayer.push(arguments);
		}
		gtag('js', new Date());

		gtag('config', 'G-8WZ7THPZ57');
	</script>
</head>

<body>
	{% place body %}

	<?php if (ConfigOld::getInstance()->cookiesWarning && !isset($_COOKIE['cookies-warning'])) { ?>

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