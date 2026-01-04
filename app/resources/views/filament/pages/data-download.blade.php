@pushOnce('styles')
	<style>
		.component-title {
			font-size: 1.5rem;
		}

		.input {
			border: 1px solid #ccc;
			border-radius: 4px;
			padding: 0.5rem;
			font-size: 1rem;
			width: 100%;
		}

		.checkbox {
			display: flex;
			align-items: center;
			gap: 0.5rem;
			font-size: 1rem;
		}

		.hidden {
			display: none;
		}

		.button {
			display: inline-flex;
			align-items: center;
			gap: 0.5rem;
			padding: 0.5rem 1rem;
			border: 2px solid currentColor;
			border-radius: 0.375rem;
			color: var(--primary-400);
			cursor: pointer;
			transition: color 0.2s;

			svg {
				width: 1.125rem;
				height: 1.125rem;
				fill: currentColor;
			}

			&:hover {
				color: var(--primary-600);
			}
		}

		.flex {
			display: flex;
		}

		.flex-wrap {
			flex-wrap: wrap;
		}

		.grid {
			display: grid;
		}

		.grid-cols-1 {
			grid-template-columns: repeat(1, minmax(0, 1fr));
		}

		.items-center {
			align-items: center;
		}

		.justify-center {
			justify-content: center;
		}

		.gap-4 {
			gap: 1rem;
		}

		.gap-6 {
			gap: 1.5rem;
		}

		.gap-8 {
			gap: 2rem;
		}

		.gap-12 {
			gap: 3rem;
		}

		.gap-20 {
			gap: 5rem;
		}

		.mx-auto {
			margin-left: auto;
			margin-right: auto;
		}

		.mt-4 {
			margin-top: 1rem;
		}

		@media (min-width: 768px) {
			.md\:grid-cols-2 {
				grid-template-columns: repeat(2, minmax(0, 1fr));
			}
		}

		.text-center {
			text-align: center;
		}

		.text-danger-600 {
			color: var(--danger-600);
		}

		.text-amber-500 {
			color: #f59e0b;
		}

		.text-2xl {
			font-size: 1.5rem;
		}
	</style>
@endpushOnce

<x-filament-panels::page>
	<div class="grid grid-cols-1 gap-20">
		<div class="grid grid-cols-1 gap-4">
			<h3 class="component-title">Risultati dettagliati</h3>
			<p>Scarica la lista degli studenti che hanno completato almeno un'attività nell'anno indicato. La lista include tutti
				i risultati ottenuti nelle varie attività. Se l'anno scolastico non è specificato, verranno scaricati i dati per
				tutti gli anni. La stessa cosa vale per
				l'anno di corso.</p>

			<livewire:admin.data-download.details />
		</div>

		<div class="grid grid-cols-1 gap-4">
			<h3 class="component-title">Lista studenti</h3>
			<p>Scarica la lista degli studenti registrati. Se l'anno scolastico non è specificato, verranno scaricati i dati per
				tutti gli anni. La stessa cosa vale per
				l'anno di corso.</p>

			<livewire:admin.data-download.students />
		</div>

		<div class="grid grid-cols-1 gap-4">
			<h3 class="component-title">Lista docenti</h3>
			<p>Scarica la lista dei docenti registrati. Se l'anno scolastico non è specificato, verrà scaricata la lista di tutti
				i docenti.</p>

			<livewire:admin.data-download.teachers />
		</div>

		<div class="grid grid-cols-1 gap-4">
			<h3 class="component-title">Lista classi</h3>

			<p>Scarica la lista delle classi registrate. Se l'anno scolastico non è specificato, verranno scaricati i dati per
				tutti gli anni.</p>

			<livewire:admin.data-download.classes />
		</div>

		<div class="grid grid-cols-1 gap-4">
			<h3 class="component-title">Lista scuole</h3>

			<livewire:admin.data-download.schools />
		</div>
	</div>
</x-filament-panels::page>
