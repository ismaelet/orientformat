@pushOnce('styles')
	<style>
		main {
			background-color: #edf0f7;
		}


		.documents {
			display: grid;
			grid-template-columns: repeat(auto-fill, minmax(25rem, 1fr));
			gap: 3rem;
		}

		#grid .form {
			height: 100%;
			padding: 3rem 2rem;
			background-color: #fff;
			border-radius: 2rem;
			box-shadow: 1rem 1rem 2rem -0.5rem hsl(252, 50%, 93%);
		}

		#grid .form:nth-child(n + 3) {
			border-top: 0;
		}

		.buttons {
			display: grid;
			gap: 0.5rem;
		}

		.pbtn.bgr-c2 {
			background-color: var(--color-tertiary-400);
		}

		/* Responsive */
		@media (max-width: 1024px) {
			#grid .form {
				padding: 1.5rem;
			}

			.main-wrap {
				padding-bottom: 4rem;
			}
		}

		@media (max-width: 480px) {
			.documents {
				grid-template-columns: minmax(0, 1fr);
			}
		}
	</style>
@endpushOnce

<x-layouts.legacy-main :$title>

	<div class="breakout mb-20 mt-12">
		<div class="grid grid-cols-1 justify-items-center gap-8">
			<x-heading.main class="text-center">Modulistica</x-heading.main>

			<x-button
				href="{{ route('teacher.dashboard') }}"
				variant="secondary"
			>Indietro</x-button>

			<p class="page-subtitle">
				Qui puoi scaricare i moduli della <span class="txt-sbold">Certificazione delle competenze</span>, del <span
					class="txt-sbold"
				>Consiglio orientativo</span> e altri documenti di supporto.
			</p>
		</div>

		<div class="columns-25rem mt-12 grid gap-8">

			<section class="form grid grid-cols-1 gap-4 rounded bg-neutral-50 p-6 shadow">

				<!-- Title -->
				<div class="title-box fa-center">
					<x-heading.component-big>UNICA</x-heading.component-big>
					<p class="stitle txt-09rem mar-t-1">Qui puoi collegarti all’ E-portfolio di UNICA, per inserire Certificazioni e
						visionare le autovalutazioni e i Capolavori inseriti dagli studenti.</p>
				</div>

				<!-- Buttons -->
				<div class="grid items-center gap-2">
					<x-button
						class="center-icon"
						size="small"
						href="https://unica.istruzione.gov.it/portale/it/orientamento/il-tuo-percorso/e-portfolio"
						target="_blank"
					>
						<x-icon-link />
						Collegati a UNICA
					</x-button>
				</div>

			</section>

			<section class="form grid grid-cols-1 gap-4 rounded bg-neutral-50 p-6 shadow">

				<!-- Title -->
				<div class="title-box fa-center">
					<x-heading.component-big>Certificazione<br>delle competenze Primo ciclo</x-heading.component-big>
					<p class="stitle txt-09rem mar-t-1">Qui puoi scaricare il modulo per la Certificazione delle Competenze.</p>
				</div>

				<!-- Buttons -->
				<div class="grid items-center gap-2">
					<x-button
						class="center-icon"
						size="small"
						href="{{ public_asset('documents/Certificazione-delle-Competenze.pdf') }}"
						download="Certificazione-delle-Competenze.pdf"
					>
						<x-icon-download />
						Scarica
						in
						PDF
					</x-button>
					<x-button
						class="center-icon"
						size="small"
						variant="secondary"
						href="{{ public_asset('documents/Certificazione-delle-Competenze.docx') }}"
						download="Certificazione-delle-Competenze.docx"
					>
						<x-icon-download />
						Scarica in DOCX
					</x-button>
				</div>
			</section>

			<section class="form grid grid-cols-1 gap-4 rounded bg-neutral-50 p-6 shadow">

				<!-- Title -->
				<div class="title-box fa-center">
					<x-heading.component-big>Certificazione<br>delle competenze Primo ciclo<br><span class="text-[0.8em]">- Modello
							Nazionale -</span></x-heading.component-big>
					<p class="stitle txt-09rem mar-t-1">Qui puoi scaricare la versione nazionale del modulo per la Certificazione delle
						Competenze.</p>
				</div>

				<!-- Buttons -->
				<div class="grid items-center gap-2">
					<x-button
						class="center-icon"
						size="small"
						href="{{ public_asset('documents/Competenze-Primo-Ciclo-Nazionali.pdf') }}"
						download="Competenze-Primo-Ciclo-Nazionali.pdf"
					>
						<x-icon-download />
						Scarica
						in
						PDF
					</x-button>
					<x-button
						class="center-icon"
						size="small"
						variant="secondary"
						href="{{ public_asset('documents/Competenze-Primo-Ciclo-Nazionali.docx') }}"
						download="Competenze-Primo-Ciclo-Nazionali.docx"
					>
						<x-icon-download />
						Scarica in DOCX
					</x-button>
				</div>
			</section>

			<section class="form grid grid-cols-1 gap-4 rounded bg-neutral-50 p-6 shadow">

				<!-- Title -->
				<div class="title-box fa-center">
					<x-heading.component-big>Certificazione<br>delle competenze Termine obbligo<br><span class="text-[0.8em]">- Modello
							Nazionale -</span></x-heading.component-big>
					<p class="stitle txt-09rem mar-t-1">Qui puoi scaricare il modulo per la Certificazione delle Competenze di Termine
						obbligo.</p>
				</div>

				<!-- Buttons -->
				<div class="grid items-center gap-2">
					<x-button
						class="center-icon"
						size="small"
						href="{{ public_asset('documents/Competenze-Fine-Obbligo-Nazionali.pdf') }}"
						download="Competenze-Fine-Obbligo-Nazionali.pdf"
					>
						<x-icon-download />
						Scarica
						in
						PDF
					</x-button>
					<x-button
						class="center-icon"
						size="small"
						variant="secondary"
						href="{{ public_asset('documents/Competenze-Fine-Obbligo-Nazionali.docx') }}"
						download="Competenze-Fine-Obbligo-Nazionali.docx"
					>
						<x-icon-download />
						Scarica in DOCX
					</x-button>
				</div>
			</section>

			<section class="form grid grid-cols-1 gap-4 rounded bg-neutral-50 p-6 shadow">

				<!-- Title -->
				<div class="title-box fa-center">
					<x-heading.component-big>Consiglio<br>orientativo</x-heading.component-big>
					<p class="stitle txt-09rem mar-t-1">Qui puoi scaricare il modulo per il Consiglio orientativo.</p>
				</div>

				<!-- Buttons -->
				<div class="grid items-center gap-2">
					<x-button
						class="center-icon"
						size="small"
						href="{{ public_asset('documents/Consiglio-Orientativo.pdf') }}"
						download="Consiglio-Orientativo.pdf"
					>
						<x-icon-download />
						Scarica
						in
						PDF
					</x-button>
					<x-button
						class="center-icon"
						size="small"
						variant="secondary"
						href="{{ public_asset('documents/Consiglio-Orientativo.docx') }}"
						download="Consiglio-Orientativo.docx"
					>
						<x-icon-download />
						Scarica
						in
						DOCX
					</x-button>
				</div>

			</section>

			<section class="form grid grid-cols-1 gap-4 rounded bg-neutral-50 p-6 shadow">

				<!-- Title -->
				<div class="title-box fa-center">
					<x-heading.component-big>Informativa privacy</x-heading.component-big>
					<p class="stitle txt-09rem mar-t-1">Qui puoi scaricare l'informativa per la privacy e il trattamento dei dati.</p>
				</div>

				<!-- Buttons -->
				<div class="grid items-center gap-2">
					<x-button
						class="center-icon"
						size="small"
						href="{{ public_asset('documents/Informativa-Privacy.pdf') }}"
						download="Informativa-Privacy.pdf"
					>
						<x-icon-download />
						Scarica
					</x-button>
				</div>
			</section>
		</div>
	</div>

</x-layouts.legacy-main>
