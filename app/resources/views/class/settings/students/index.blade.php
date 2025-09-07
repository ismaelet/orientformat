@pushOnce('styles')
	<style>
		.dashboard-list__row {
			&:nth-child(even) {
				background-color: var(--color-slate-100);
			}
		}
	</style>
@endpushOnce

<x-layouts.class-dashboard :$class>

	<!-- List -->
	<section class="dashboard-panel">
		<h1 class="dashboard-panel__title">Gestione studenti</h1>

		<livewire:administrator.student.table :class="$class" />

	</section>

	<!-- Info -->
	<p class="stitle txt-1rem mar-t-3 fa-center px-8">
		Qui puoi controllare la lista degli studenti e dei corrispettivi username.<br>
		Se uno studente si registrasse per errore più di una volta, o se vedessi nella lista uno studente che non fa parte
		della tua classe, puoi disabilitarlo cliccando su <strong>disattiva</strong>.<br>
		Se invece uno studente si dimenticasse l'username, puoi verificare nella lista qual è e comunicarglielo.
	</p>

	<!-- Print -->
	<div
		class="center-content mt-8 grid"
		x-data
	>
		<x-button
			class="center-icon"
			@click="printPage"
		>
			<x-icon-print class="w-5" />
			Stampa
		</x-button>
	</div>

</x-layouts.class-dashboard>
