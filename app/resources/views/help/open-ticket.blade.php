@pushOnce('styles')
	<style>
		/* Body */
		#content {
			padding-top: 8rem;
			padding-bottom: 7rem;
		}

		.stitle {
			font-size: 3rem;
			font-weight: 600;
			letter-spacing: 0.1em;
		}

		/* Contact data */
		.contact-icon {
			display: inline-block;
			width: 1.4rem;
			height: 1.4rem;
			margin-right: 1rem;
		}

		.contact-icon .bgr:hover {
			background-color: var(--color-primary-400);
		}

		.data-txt {
			margin-bottom: 10px;
			font-size: 0.9rem;
		}

		.data-txt a {
			font-weight: bold;
			transition: color 0.3s;
		}

		.data-txt a:hover {
			color: var(--color-primary-400);
		}

		.main-img {
			max-width: 12rem;
			margin-top: 2rem;
			margin-inline: auto;
		}

		/* Contact form */
		.form-lbl {
			padding-top: 1rem;
			transform-origin: left;
			transform: translateY(2rem) scale(1.2);
			line-height: 1rem;
			pointer-events: none;
			z-index: 1;
			transition: transform 0.3s, color 0.3s;
		}

		.focus .form-lbl {
			color: var(--color-primary-400);
			transform: translateY(0.5rem) scale(1);
		}

		.readonly .form-lbl {
			color: var(--text-color-strong);
		}

		.form-inp,
		.form-textarea {
			display: inline-block;
			background-color: transparent;
			box-shadow: unset !important;
			border-radius: 0;
			width: 100%;
			border: none;
			outline: none;
			border-bottom: 1px solid #999;
			padding: 0;
			margin: 0;
			font-family: var(--font-text);
			font-size: 0.9rem;
			box-sizing: border-box;
		}

		.form-inp {
			line-height: 3rem;
		}

		.form-textarea {
			height: 13rem;
			padding-top: 1rem;
			resize: none;
		}

		#submit {}

		/* Responsive */
		@media (max-width: 1024px) {
			#content {
				padding: 0;
			}

			#grid {
				display: flex;
				flex-direction: column;
				grid-gap: 0;
			}

			.grid-cell {
				width: 600px;
				max-width: 100%;
				margin: 0 auto;
			}

			#form {
				order: 1;
				padding: 4rem 0;
				border-bottom: 2px solid #777;
			}

			#data {
				order: 2;
				padding: 4rem 0;
			}
		}

		@media (max-width: 480px) {
			#title {
				letter-spacing: 0.3em;
				margin-right: -0.3em;
			}
		}
	</style>
@endpushOnce

<x-layouts.legacy-main :title="$title">

	<!-- Content -->
	<div id="content">

		<div class="main-wrap">

			<div
				id="grid"
				class="grid2 gap3 al-top"
			>

				<!-- Contacts data -->
				<section
					id="data"
					class="grid-cell"
				>
					<x-heading.main class="text-center">Supporto</x-heading.main>

					<div class="br-b-1 brb-dashed br-9 mar-v-2"></div>

					<x-button
						href="{{ route('help') }}"
						class="center-icon mb-4 w-full"
						variant="secondary"
					>
						<x-icon-link />
						Domande frequenti</x-button>

					<p class="data-txt txt-1rem txt-lh2">
						Se hai qualche dubbio sul funzionamento della piattaforma puoi provare a cercare la tua domanda tra le domande
						frequenti, qui sopra, oppure se vuoi contattarci direttamente puoi usare il presente in questa pagina e ti
						risponderemo al più presto.<br><br>

						Per sfruttare al meglio la piattaforma consigliamo di leggere <a
							class="txt-c2"
							href="<?= client_url('/help?category=4&topic=8#topic8') ?>"
						>I 10 passi per utilizzare OrientFormat</a>.
					</p>

					<x-svg-help class="mx-auto mt-4 max-w-48" />
				</section>

				<!-- Contact form -->
				<section
					id="form"
					class="grid-cell"
				>

					<form
						method="POST"
						autocomplete="off"
						action="{{ route('help.ticket.store') }}"
					>
						<?= csrf_field() ?>

						<div
							id="form-anch"
							class="anchor"
						></div>

						<x-heading.main class="text-center">Scrivici</x-heading.main>

						@session('success')
							<x-alerts.success class="mt-8">Abbiamo ricevuto la richiesta, ti risponderemo il prima
								possibile</x-alerts.success>
						@endsession

						@error('content')
							<x-alerts.error class="mt-8">Errore: il messaggio non ha superato i nostri filtri anti-spam. Puoi scrivere
								direttamente a <a
									href="mailto:iprase@iprase.tn.it"
									class="font-bold"
								>iprase@iprase.tn.it</a>, invece di usare questo modulo.
							</x-alerts.error>
						@enderror

						<div class="form-lbl-box focus readonly">
							<p class="form-lbl">Nome e cognome</p>
						</div>
						<input
							type="text"
							name="name"
							value="{{ $user?->full_name }}"
							class="form-inp"
							required
							@readonly($user)
						>

						<div class="form-lbl-box focus readonly">
							<p class="form-lbl">Indirizzo e-mail</p>
						</div>
						<input
							type="email"
							name="email"
							value="{{ $user?->email }}"
							class="form-inp"
							required
							@readonly($user)
						>

						<div class="form-lbl-box">
							<p class="form-lbl">Messaggio</p>
						</div>
						<textarea
						 name="message"
						 class="form-textarea"
						 maxlength="500"
						 onfocus="$(this).prev().addClass('focus')"
						 onblur="if (!$(this).val().length) {$(this).prev().removeClass('focus')}"
						 required
						></textarea>

						<div class="mt-8 flex justify-end">
							<x-button type="submit">
								<x-icon-send-email />
								Invia
							</x-button>
						</div>
					</form>
				</section>
			</div>
		</div>
	</div>

</x-layouts.legacy-main>
