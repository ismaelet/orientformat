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

@pushOnce('styles')
	<style>
		/* Containers */
		footer {
			--content-width: 1400px;
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
			padding-top: min(15vw, 5rem);
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

		footer .font-bold {
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
			color: var(--_color-neutral-400);
			transition: background-color 0.4s;
		}

		.f-contact:hover {
			color: var(--color-primary-400);
		}

		#footer-credits {
			border-color: hsl(0, 0%, 100%, 0.1);
		}

		#footer-credits .text-icon {
			width: 0.7rem;
			height: 0.7rem;
			vertical-align: middle;
		}

		#footer-notes {
			background-color: var(--color-tertiary-800);
		}

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
@endPushOnce

<footer class="">

	<div
		id="footer-wrap"
		class="content-grid"
	>

		<div class="footer__content">
			<div
				id="footer-body"
				class="al-top grid"
			>

				<div
					id="f-contacts"
					class="footer-col"
				>

					<a href="<?= config('custom.contacts.web.url') ?>">
						<img
							id="f-logo"
							class="footer__logo--light"
							src="<?= asset('legacy/images//logo/logo-white.webp') ?>"
						>
						<img
							id="f-logo"
							class="footer__logo--dark"
							src="<?= asset('legacy/images//logo/logo.webp') ?>"
						>
					</a>

					<p class="mb-4">
						Via Tartarotti, 15 - 38068 Rovereto<br>
						Tel. <a
							class="text-link"
							href="tel:+390461494360"
						>+39 0461 494360</a>, <span class="inline-block">Fax <span
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

					<div class="flex gap-4">
						<a
							class="f-contact flex h-6"
							href="<?= config('custom.contacts.twitter.url') ?>"
						>
							<x-icon-twitter />
						</a>

						<a
							class="f-contact flex h-6"
							href="<?= config('custom.contacts.facebook.url') ?>"
						>
							<x-icon-facebook />
						</a>

						<a
							class="f-contact flex h-6"
							href="<?= config('custom.contacts.instagram.url') ?>"
						>
							<x-icon-instagram />
						</a>

					</div>
				</div>

				@foreach ($f_columns as $f_column)
					<div class="footer-col pt-4">

						<p class="footer-title mb-4 text-lg font-bold">
							<?= $f_column['title'] ?>
						</p>

						<div class="footer__links grid gap-2">

							@foreach ($f_column['links'] as $f_link)
								@if (isset($f_link[1]))
									<p class="footer-link">
										<a
											class="hover:text-primary transition-colors"
											href="<?= $f_link[1] ?>"
										><?= $f_link[0] ?></a>
									</p>
								@else
									<p class="footer-link"><?= $f_link[0] ?></p>
								@endif
							@endforeach
						</div>
					</div>
				@endforeach

			</div>

			<div
				id="footer-credits"
				class="grid gap-4 border-t pt-8"
			>
				<div class="footer-credit">
					<p class="flex flex-wrap items-center gap-2">Autore:
						<span class="font-bold">Luigi Tuffanelli</span>
						&middot;
						<a
							class="hover:text-primary flex items-center gap-2 transition-colors"
							href="https://luigituffanelli.eu"
							target="_blank"
						>
							Curriculum
							<x-icon-external-link class="w-3" />
						</a>
					</p>

					<p class="mt-2">
						Insegnante, formatore e docente presso le Università di Trento e di Bolzano. Ha collaborato frequentemente con
						l’Iprase e con il Centro Studi Edizioni Erickson. Ha numerose pubblicazioni con gli editori Giunti, La Nuova
						Italia, Edizioni Erickson e diverse riviste di didattica e pedagogia.
					</p>
				</div>

				<div class="footer-credit">
					<p class="flex flex-wrap items-center gap-2">
						Sito web realizzato da: <a
							class="hover:text-primary text-neutral-100 transition-colors"
							href="mailto:ismaele.tuffanelli@gmail.com"
						>Ismaele Tuffanelli</a>
					</p>
				</div>
			</div>
		</div>
	</div>

	<p
		id="footer-notes"
		class="mt-12 px-8 py-4 text-center"
	>
		Copyright © <?= getdate()['year'] ?> Iprase - Istituto provinciale per la ricerca e la sperimentazione educativa, Ente
		strumentale della Provincia Autonoma di Trento
	</p>
</footer>
