<?php

// elements

use Illuminate\Support\Facades\Vite;

$f_comp['logo'] = false;
$f_comp['contacts'] = true;

// links
$f_columns = [
	[
		'title' => __('Explore'),
		'links' => [
			['Home', route('home')],
			['Supporto', route('help')],
		]
	],
	[
		'title' => __('Legal Information'),
		'links' => [
			['C.F. 96023310228'],
		]
	],
	[
		'title' => __('Useful Links'),
		'links' => [
			['Indire', 'http://www.indire.it'],
			['Invalsi', 'http://www.invalsi.it'],
			['Miur', 'http://www.miur.gov.it'],
			['Pat', 'http://www.provincia.tn.it'],
			['Vivoscuola', 'http://www.vivoscuola.it/'],
		]
	],
];

// contacts
$f_contacts = ['inst', 'fb', 'mail'];
?>

<style>
	/* Containers */
	footer {
		--_color-neutral-400: var(--color-tertiary-100);
		--_color-neutral-700: #fff;
		background-color: var(--color-tertiary-700);
		color: var(--_color-neutral-400);
	}

	footer .text-link {
		color: var(--_color-neutral-700);
	}

	footer::before {
		content: '';
		display: block;
		height: 0.5rem;
		background: var(--gradient);
	}

	.footer__content {
		padding-block: min(15vw, 5rem);
	}

	#footer-body {
		grid-template-columns: 0.4fr repeat(3, 0.2fr);
	}

	/* Main links */
	.footer-col {
		padding-bottom: 2rem;
		padding-left: 10px;
	}

	#f-contacts {
		padding-left: 0;
	}

	footer .fw-bold {
		color: var(--_color-neutral-700);
		font-weight: var(--font-weight-medium);
	}

	.footer-title {
		display: flex;
		color: var(--_color-neutral-700);
		align-items: center;
		gap: 0.5rem;
	}

	.footer-title::before {
		content: '';
		display: block;
		width: 3px;
		height: 1.5em;
		background-color: var(--color-primary-400);
	}

	#f-logo {
		width: 10rem;
		height: auto;
		max-width: 100%;
		margin-bottom: 1rem;
	}

	.footer__logo--dark {
		display: none;
	}

	.f-contact {
		color: var(--_color-neutral-700);
		width: 2.5rem;
		height: 2.5rem;
		transition: background-color 0.4s;
	}

	.f-contact:hover {
		color: var(--color-primary-400);
	}

	.f-contact svg {
		opacity: 0.8;
		width: 50%;
	}

	/*
* Credits
*/
	#footer-credits {
		border-color: hsl(0, 0%, 100%, 0.1);
	}

	#footer-credits .text-icon {
		width: 0.7rem;
		height: 0.7rem;
		vertical-align: middle;
	}

	/*
* Notes
*/
	#footer-notes {
		background-color: var(--color-tertiary-800);
	}

	/* Responsive */
	@media (max-width: 768px) {
		#footer-body {
			grid-template-columns: repeat(3, 1fr);
		}

		#f-contacts {
			grid-column-start: 1;
			grid-column-end: 4;
		}
	}

	@media (max-width: 480px) {
		#footer-body {
			grid-template-columns: repeat(2, 1fr);
		}

		#f-contacts {
			grid-column-start: 1;
			grid-column-end: 3;
		}
	}
</style>

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
							<img
								src="<?= Vite::image('logo/logo-white.png') ?>"
								class="mb-4 max-w-72">
						</a>

						<p class="mb-4">
							Via Tartarotti, 15 - 38068 Rovereto<br>
							Tel. <a class="text-link" href="tel:+390461494360">+39 0461 494360</a>, <span class="inlb">Fax <span class="text-link" href="tel:+390461494399">+39 0461 494399</span></span><br>
							<a class="text-link" href="mailto:iprase@iprase.tn.it">iprase@iprase.tn.it</a>, <a class="text-link" href="mailto:iprase@pec.provincia.tn.it">iprase@pec.provincia.tn.it</a>
						</p>

						<div class="flex" data-spacing="200">
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

						<div class="footer__links grid" data-spacing="200">

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
						<?= __('footer.creator') ?>
					</p>
				</div>

				<div class="footer-credit">
					<p class="flex-line gap-2"><?= __('footer.developer') ?>: <a class="text-link" href="mailto:ismaele.tuffanelli@gmail.com">Ismaele Tuffanelli</a>
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