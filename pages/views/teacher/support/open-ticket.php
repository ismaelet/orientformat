{% block main %}

<!-- Content -->
<div id="content">

	<div class="main-wrap">

		<div id="grid" class="grid2 gap3 al-top">

			<!-- Contacts data -->
			<section id="data" class="grid-cell">
				<h2 class="stitle mar-b-2">Supporto</h2>

				<div class="br-b-1 brb-dashed br-9 mar-v-2"></div>

				<a href="<?= client_url('/help') ?>" class="button button--secondary button--full-width mar-b-2 block push-center">Domande frequenti</a>

				<p class="data-txt txt-1rem txt-lh2">
					Se hai qualche dubbio sul funzionamento della piattaforma puoi provare a cercare la tua domanda tra le domande frequenti, qui sopra, oppure se vuoi contattarci direttamente puoi usare il presente in questa pagina e ti risponderemo al più presto.<br><br>

					Per sfruttare al meglio la piattaforma consigliamo di leggere <a class="txt-c2" href="<?= client_url('/help?category=4&topic=8#topic8') ?>">I 10 passi per utilizzare OrientFormat</a>.
				</p>

				<img class="main-img img-fit" src="<?= client_path('image.svg') ?>" alt="">
			</section>

			<!-- Contact form -->
			<section id="form" class="grid-cell">

				<form method="POST" autocomplete="off" action="#form">

					<div id="form-anch" class="anchor"></div>

					<h2 class="stitle fa-center">Scrivici</h2>

					<?php if ($sent) { ?>

						<p class="confirmation-message mar-t-2">Abbiamo ricevuto la richiesta, ti risponderemo il prima possibile</p>

					<?php } ?>

					<?php if ($error == 'word_bad') { ?>

						<p class="error-message">Errore: il messaggio non ha superato i nostri filtri anti-spam. Puoi scrivere direttamente a <a href="mailto:<?= $contact ?>" class="fw-bold"><?= $contact ?></a>, invece di usare questo modulo.</p>

					<?php } ?>

					<div class="form-lbl-box focus readonly">
						<p class="form-lbl">Nome e cognome</p>
					</div>
					<input type="text" value="<?= user()->fullName ?>" class="form-inp" readonly>

					<div class="form-lbl-box focus readonly">
						<p class="form-lbl">Indirizzo e-mail</p>
					</div>
					<input type="email" value="<?= user()->email ?>" class="form-inp" readonly>

					<div class="form-lbl-box">
						<p class="form-lbl">Messaggio</p>
					</div>
					<textarea name="text" class="form-textarea" maxlength="500" onfocus="$(this).prev().addClass('focus')" onblur="if (!$(this).val().length) {$(this).prev().removeClass('focus')}" required></textarea>

					<div class="txt-rig mar-t-2">
						<button type="submit" id="submit" name="submit" class="button mob-full">Invia</button>
					</div>
				</form>
			</section>

		</div>
	</div>
</div>

{% end main %}