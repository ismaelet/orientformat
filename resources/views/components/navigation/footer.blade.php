@php

	// elements
	$f_comp['logo'] = false;
	$f_comp['contacts'] = true;

	// links
	$f_columns = [
	    [
	        'title' => 'Esplora',
	        'links' => [['Home', client_url('/')], ['Supporto', client_url('/help')]],
	    ],
	    [
	        'title' => 'Legali',
	        'links' => [['C.F. 96023310228']],
	    ],
	    [
	        'title' => 'Link utili',
	        'links' => [
	            ['Indire', 'http://www.indire.it'],
	            ['Invalsi', 'http://www.invalsi.it'],
	            ['Miur', 'http://www.miur.gov.it'],
	            ['Pat', 'http://www.provincia.tn.it'],
	            ['Vivoscuola', 'http://www.vivoscuola.it/'],
	        ],
	    ],
	];

	// contacts
	$f_contacts = ['inst', 'fb', 'mail'];

@endphp

@push('styles')
	<style>
		/* Containers */
		footer {
			--_fc-400: var(--clr-tertiary-100);
			--_fc-700: #fff;
			background-color: var(--clr-tertiary-700);
			color: var(--_fc-400);
		}

		footer .text-link {
			color: var(--_fc-700);
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
			color: var(--_fc-700);
			font-weight: var(--fw-medium);
		}

		.footer-title {
			display: flex;
			color: var(--_fc-700);
			align-items: center;
			gap: 0.5rem;
		}

		.footer-title::before {
			content: '';
			display: block;
			width: 3px;
			height: 1.5em;
			background-color: var(--clr-primary-400);
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
			color: var(--_fc-700);
			width: 2.5rem;
			height: 2.5rem;
			transition: background-color 0.4s;
		}

		.f-contact:hover {
			color: var(--clr-primary-400);
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
			background-color: var(--clr-tertiary-800);
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
@endpush

<footer class="">

	<div
		id="footer-wrap"
		class="main-wrap"
	>

		<div class="footer__content">
			<div
				id="footer-body"
				class="al-top grid"
			>

				<?php if ($f_comp['contacts']) { ?>
				<div
					id="f-contacts"
					class="footer-col"
				>

					<p class="footer-title fw-bold txt-1rem mar-b-1 hidden">
						<span class="dent bgr-c2"></span>
						Contatti
					</p>

					<a href="<?= config('custom.contacts.web.url') ?>">
						<img
							id="f-logo"
							class="footer__logo--light"
							src="<?= asset('/images/logo/logo-white.webp') ?>"
						>
						<img
							id="f-logo"
							class="footer__logo--dark"
							src="<?= asset('/images/logo/logo.webp') ?>"
						>
					</a>

					<p class="mar-b-1">
						Via Tartarotti, 15 - 38068 Rovereto<br>
						Tel. <a
							class="text-link"
							href="tel:+390461494360"
						>+39 0461 494360</a>, <span class="inlb">Fax <span
								class="text-link"
								href="tel:+390461494399"
							>+39 0461 494399</span></span><br>
						<a
							class="text-link"
							href="mailto:iprase@iprase.tn.it"
						>iprase@iprase.tn.it</a>, <a
							class="text-link"
							href="mailto:iprase@pec.provincia.tn.it"
						>iprase@pec.provincia.tn.it</a>
					</p>

					<div
						class="flex-group"
						data-spacing="200"
					>
						<a
							class="f-contact"
							href="<?= config('custom.contacts.twitter.url') ?>"
						>
							<?= embed_icon('contacts/twitter') ?>
						</a>

						<a
							class="f-contact"
							href="<?= config('custom.contacts.facebook.url') ?>"
						>
							<?= embed_icon('contacts/facebook') ?>
						</a>

						<a
							class="f-contact"
							href="<?= config('custom.contacts.instagram.url') ?>"
						>
							<?= embed_icon('contacts/instagram') ?>
						</a>

					</div>
				</div>
				<?php } ?>

				<?php foreach ($f_columns as $f_column) { ?>

				<div class="footer-col pad-t-1">

					<p class="footer-title txt-1rem mar-b-1 fw-bold">
						<?= $f_column['title'] ?>
					</p>

					<div
						class="footer__links grid-flow"
						data-spacing="200"
					>

						<?php foreach ($f_column['links'] as $f_link) {

								if (isset($f_link[1])) { ?>

						<p class="footer-link">
							<a
								class="fc-hover-primary"
								href="<?= $f_link[1] ?>"
							><?= $f_link[0] ?></a>
						</p>

						<?php } else { ?>

						<p class="footer-link"><?= $f_link[0] ?></p>

						<?php } ?>

						<?php } ?>
					</div>

				</div>

				<?php } ?>

			</div>

			<div
				id="footer-credits"
				class="gap1 pad-t-2 br-t-1 br-d grid"
			>
				<div class="footer-credit">
					<p class="flex-line gap05">Autore:
						<span class="fw-bold">Luigi Tuffanelli</span>
						&middot;
						<a
							class="text-link"
							href="https://luigituffanelli.eu"
							target="_blank"
						>
							Curriculum
							<?= embed_icon('external-link') ?>
						</a>
					</p>

					<p class="mar-t-05">
						Insegnante, formatore e docente presso le Università di Trento e di Bolzano. Ha collaborato frequentemente con
						l’Iprase e con il Centro Studi Edizioni Erickson. Ha numerose pubblicazioni con gli editori Giunti, La Nuova
						Italia, Edizioni Erickson e diverse riviste di didattica e pedagogia.
					</p>
				</div>

				<div class="footer-credit">
					<p class="flex-line gap05">
						Sito web realizzato da: <a
							class="text-link"
							href="mailto:ismaele.tuffanelli@gmail.com"
						>Ismaele Tuffanelli</a>
					</p>
				</div>
			</div>
		</div>
	</div>

	<p
		id="footer-notes"
		class="pad-v-1 pad-h-2 txt-cen"
	>
		Copyright © <?= getdate()['year'] ?> Iprase - Istituto provinciale per la ricerca e la sperimentazione educativa, Ente
		strumentale della Provincia Autonoma di Trento
	</p>
</footer>
