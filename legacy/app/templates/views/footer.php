<footer class="">

	<div id="footer-wrap" class="main-wrap">

		<div class="footer__content">
			<div id="footer-body" class="grid al-top">

				<?php if ($f_comp['contacts']) { ?>
					<div id="f-contacts" class="footer-col">

						<p class="footer-title fw-bold txt-1rem mar-b-1 hidden">
							<span class="dent bgr-c2"></span>
							Contatti
						</p>

						<a href="<?= sysData('cont-web_link') ?>">
							<img id="f-logo" class="footer__logo--light" src="<?= asset('/images/logo/logo-white.webp') ?>">
							<img id="f-logo" class="footer__logo--dark" src="<?= asset('/images/logo/logo.webp') ?>">
						</a>

						<p class="mar-b-1">
							Via Tartarotti, 15 - 38068 Rovereto<br>
							Tel. <a class="text-link" href="tel:+390461494360">+39 0461 494360</a>, <span class="inlb">Fax <span class="text-link" href="tel:+390461494399">+39 0461 494399</span></span><br>
							<a class="text-link" href="mailto:iprase@iprase.tn.it">iprase@iprase.tn.it</a>, <a class="text-link" href="mailto:iprase@pec.provincia.tn.it">iprase@pec.provincia.tn.it</a>
						</p>

						<div class="flex-group" data-spacing="200">
							<a class="f-contact" href="<?= sysData('cont-twitter-link') ?>">
								<?= embed_icon('contacts/twitter') ?>
							</a>

							<a class="f-contact" href="<?= sysData('cont-facebook-link') ?>">
								<?= embed_icon('contacts/facebook') ?>
							</a>

							<a class="f-contact" href="<?= sysData('cont-instagram-link') ?>">
								<?= embed_icon('contacts/instagram') ?>
							</a>

							<a class="f-contact" href="<?= sysData('cont-telegram-link') ?>">
								<?= embed_icon('contacts/telegram') ?>
							</a>

							<a class="f-contact" href="<?= sysData('cont-vimeo-link') ?>">
								<?= embed_icon('contacts/vimeo') ?>
							</a>

						</div>
					</div>
				<?php } ?>

				<?php foreach ($f_columns as $f_column) { ?>

					<div class="footer-col pad-t-1">

						<p class="footer-title txt-1rem mar-b-1 fw-bold">
							<?= $f_column['title'] ?>
						</p>

						<div class="footer__links grid-flow" data-spacing="200">

							<?php foreach ($f_column['links'] as $f_link) {

								if (isset($f_link[1])) { ?>

									<p class="footer-link">
										<a class="fc-hover-primary" href="<?= $f_link[1] ?>"><?= $f_link[0] ?></a>
									</p>

								<?php } else { ?>

									<p class="footer-link"><?= $f_link[0] ?></p>

								<?php } ?>

							<?php } ?>
						</div>

					</div>

				<?php } ?>

			</div>

			<div id="footer-credits" class="grid gap1 pad-t-2 br-t-1 br-d">
				<div class="footer-credit">
					<p class="flex-line gap05">Autore:
						<span class="fw-bold ">Luigi Tuffanelli</span>
						&middot;
						<a class="text-link" href="https://luigituffanelli.eu" target="_blank">
							Curriculum
							<?= embed_icon('external-link') ?>
						</a>
					</p>

					<p class="mar-t-05">
						Insegnante, formatore e docente presso le Università di Trento e di Bolzano. Ha collaborato frequentemente con l’Iprase e con il Centro Studi Edizioni Erickson. Ha numerose pubblicazioni con gli editori Giunti, La Nuova Italia, Edizioni Erickson e diverse riviste di didattica e pedagogia.
					</p>
				</div>

				<div class="footer-credit">
					<p class="flex-line gap05">
						Sito web realizzato da: <a class="text-link" href="mailto:ismaele.tuffanelli@gmail.com">Ismaele Tuffanelli</a>
					</p>
				</div>
			</div>
		</div>
	</div>

	<p id="footer-notes" class="pad-v-1 pad-h-2 txt-cen">
		Copyright © <?= getdate()['year'] ?> Iprase - Istituto provinciale per la ricerca e la sperimentazione educativa, Ente strumentale della Provincia Autonoma di Trento
	</p>
</footer>