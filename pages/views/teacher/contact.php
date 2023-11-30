<?php

/* OLD

{% block main %}

<!-- Slider -->
<div id="slider" class="grid">

	<div id="bgr" class="bgr" <?= background_image('bgr.png') ?>></div>

	<h1 id="title" class="txt-c3 fa-center txt-upp">Contatti</h1>

</div>

</div>

<!-- Content -->
<div id="content">

	<div class="main-wrap">

		<div id="grid" class="grid2 gap3 al-top">

			<!-- Contacts data -->
			<section id="data" class="grid-cell">

				<h1 class="stitle txt-3rem mar-b-2">Orientamento<br><span class="fw-bold">Formativo</span></h1>

				<div class="br-b-1 brb-dashed br-9 mar-v-2"></div>

				<p class="data-txt txt-1rem txt-lh2">
					Se hai qualche dubbio sul funzionamento della piattaforma o hai qualche domanda puoi contattarci usando questo formulario. Ti risponderemo al più presto all'indirizzo e-mail indicato.
				</p>
			</section>

			<!-- Contact form -->
			<section id="form" class="grid-cell">

				<form method="POST" autocomplete="off" action="#form">

					<div id="form-anch" class="anchor"></div>

					<h1 class="stitle txt-3rem fw-bold fa-center">Scrivici</h1>

					<?php if ($sent) { ?>

						<p class="confirmation-message mar-t-2">Messaggio inviato ti risponderemo il prima possibile</p>

					<?php } ?>

					<?php if ($error == 'word_bad') { ?>

						<p class="error-warning">Errore: il messaggio non ha superato i nostri filtri anti-spam. Puoi scrivere direttamente a <a href="mailto:<?= $contact ?>" class="fw-bold"><?= $contact ?></a>, invece di usare questo modulo.</p>

					<?php } ?>

					<div class="form-lbl-box">
						<p class="form-lbl">Indirizzo e-mail</p>
					</div>

					<input type="email" name="mail" class="form-inp" onfocus="$(this).prev().addClass('focus')" onblur="if (!$(this).val().length) {$(this).prev().removeClass('focus')}" required>

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