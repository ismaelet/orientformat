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
		<h1 class="dashboard-panel__title">Lista degli studenti</h1>

		<?php if ($students->count()) { ?>

		<div
			class="dashboard-list"
			style="--columns: 7;"
		>
			<div class="dashboard-list__row dashboard-list__row--header">
				<p class="dashboard-list__field">Cognome</p>
				<p class="dashboard-list__field">Nome</p>
				<p class="dashboard-list__field">Username</p>
				<p class="dashboard-list__field">E-mail</p>
				<p class="dashboard-list__field">Registrato il</p>
				<p class="dashboard-list__field text-center">Attivo/a</p>
				<div class="dashboard-list__field"></div>
			</div>

			<?php foreach ($students as $student) { ?>

			<form
				class="dashboard-list__row"
				id="row<?= $student->id ?>"
				method="POST"
				action="#row<?= $student->id ?>"
			>
				<p class="dashboard-list__field"><?= $student->last_name ?></p>
				<p class="dashboard-list__field"><?= $student->first_name ?></p>
				<p class="dashboard-list__field"><?= $student->username ?></p>
				<p class="dashboard-list__field"><?= $student->user->email ?></p>
				<p class="dashboard-list__field"><?= $student->created_at_date ?></p>

				<div class="dashboard-list__field flex justify-center">
					<x-dynamic-component
						:component="$student->status ? 'icon-correct' : 'icon-error'"
						@class([
							'w-5',
							'text-success-500' => $student->status,
							'text-error-500' => !$student->status,
						])
					/>
				</div>
				<div class="dashboard-list__field dashboard-list__field--buttons">

					<?php if ($student->status) { ?>

					<button
						type="submit"
						name="deactivate"
						class="dashboard-list__button"
						data-color="red"
						value="<?= $student->id ?>"
					>Disattiva</button>

					<?php } else { ?>

					<button
						type="submit"
						name="activate"
						class="dashboard-list__button"
						data-color="green"
						value="<?= $student->id ?>"
					>Attiva</button>

					<?php } ?>

					<button
						type="submit"
						name="reset"
						class="dashboard-list__button"
						value="<?= $student->id ?>"
						onclick="return confirm('Confermi di voler generare una nuova password per questo alunno/a?')"
					>Reset della password</button>

				</div>
			</form>

			<?php } ?>

		</div>

		<?php } else { ?>

		<!-- Empty -->
		<p class="center-content mar-v-5">Non ci sono studenti registrati in questa classe.</p>

		<?php } ?>

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
