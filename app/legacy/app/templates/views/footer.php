<footer class="">

	<div id="footer-wrap" class="main-wrap">

		<div class="footer__content">
			<div id="footer-body" class="al-top grid">

				<?php if ($f_comp['contacts']) { ?>
					<div id="f-contacts" class="footer-col">

						<p class="footer-title font-bold txt-1rem mb-4 hidden">
							<span class="dent bg-secondary"></span>
							Contatti
						</p>

						<a href="<?= config('custom.contacts.web.url') ?>">
							<img id="f-logo" class="footer__logo--light" src="<?= asset('/images/logo/logo-white.webp') ?>">
							<img id="f-logo" class="footer__logo--dark" src="<?= asset('/images/logo/logo.webp') ?>">
						</a>

						<p class="mb-4">
							Via Tartarotti, 15 - 38068 Rovereto<br>
							Tel. <a class="text-link" href="tel:+390461494360">+39 0461 494360</a>, <span class="inlb">Fax <span class="text-link" href="tel:+390461494399">+39 0461 494399</span></span><br>
							<a class="text-link" href="mailto:iprase@iprase.tn.it">iprase@iprase.tn.it</a>, <a class="text-link" href="mailto:iprase@pec.provincia.tn.it">iprase@pec.provincia.tn.it</a>
						</p>

						<div class="flex-group" data-spacing="200">
							<a class="f-contact" href="<?= config('custom.contacts.twitter.url') ?>">
								<?= embed_icon('contacts/twitter') ?>
							</a>

							<a class="f-contact" href="<?= config('custom.contacts.facebook.url') ?>">
								<?= embed_icon('contacts/facebook') ?>
							</a>

							<a class="f-contact" href="<?= config('custom.contacts.instagram.url') ?>">
								<?= embed_icon('contacts/instagram') ?>
							</a>

						</div>
					</div>
				<?php } ?>

				<?php foreach ($f_columns as $f_column) { ?>

					<div class="footer-col pt-4">

						<p class="footer-title txt-1rem mb-4 font-bold">
							<?= $f_column['title'] ?>
						</p>

						<div class="footer__links grid-flow" data-spacing="200">

							<?php foreach ($f_column['links'] as $f_link) {

								if (isset($f_link[1])) { ?>

									<p class="footer-link">
										<a class="hover:text-primary transition-colors" href="<?= $f_link[1] ?>"><?= $f_link[0] ?></a>
									</p>

								<?php } else { ?>

									<p class="footer-link"><?= $f_link[0] ?></p>

								<?php } ?>

							<?php } ?>
						</div>

					</div>

				<?php } ?>

			</div>

			<div id="footer-credits" class="gap-4 pt-8 br-t-1 br-d grid">
				<div class="footer-credit">
					<p class="flex-line gap-2">Autore:
						<span class="font-bold text-neutral-100">Luigi Tuffanelli</span>
						&middot;
						<a class="text-link" href="https://luigituffanelli.eu" target="_blank">
							Curriculum
							<?= embed_icon('external-link') ?>
						</a>
					</p>

					<p class="mt-2">
						Insegnante, formatore e docente presso le Università di Trento e di Bolzano. Ha collaborato frequentemente con
						l’Iprase e con il Centro Studi Edizioni Erickson. Ha numerose pubblicazioni con gli editori Giunti, La Nuova
						Italia, Edizioni Erickson e diverse riviste di didattica e pedagogia.
					</p>
				</div>

				<div class="footer-credit">
					<p class="flex-line gap-2">
						Sito web realizzato da: <a class="text-link" href="mailto:ismaele.tuffanelli@gmail.com">Ismaele Tuffanelli</a>
					</p>
				</div>
			</div>
		</div>
	</div>

	<p id="footer-notes" class="py-4 px-8 text-center">
		Copyright © <?= getdate()['year'] ?> Iprase - Istituto provinciale per la ricerca e la sperimentazione educativa, Ente
		strumentale della Provincia Autonoma di Trento
	</p>
</footer>