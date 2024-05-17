{% block dashboard-body %}

<!-- List -->
<section class="dashboard-panel">
	<h1 class="dashboard-panel__title">Lista degli studenti</h1>

	<?php if ($studentCount) { ?>

		<div class="dashboard-list">
			<div class="dashboard-list__row dashboard-list__row--header">
				<p class="dashboard-list__field">Cognome</p>
				<p class="dashboard-list__field">Nome</p>
				<p class="dashboard-list__field">Username</p>
				<p class="dashboard-list__field">Registrato il</p>
				<p class="dashboard-list__field">Attivo</p>
				<div class="dashboard-list__field"></div>
			</div>

			<?php foreach (schoolClass()->students as $student) { ?>

				<form class="dashboard-list__row" id="row<?= $student->id ?>" method="POST" action="#row<?= $student->id ?>">
					<p class="dashboard-list__field"><?= $student->lastName ?></p>
					<p class="dashboard-list__field"><?= $student->firstName ?></p>
					<p class="dashboard-list__field"><?= $student->username ?></p>
					<p class="dashboard-list__field"><?= $student->user->time ?></p>

					<div class="dashboard-list__field"><?= snippet_binary_icon($student->status) ?></div>
					<div class="dashboard-list__field dashboard-list__field--buttons">

						<?php if ($student->status) { ?>

							<button type="submit" name="deactivate" class="dashboard-list__button" data-color="red" value="<?= $student->id ?>">Disattiva</button>

						<?php } else { ?>

							<button type="submit" name="activate" class="dashboard-list__button" data-color="green" value="<?= $student->id ?>">Attiva</button>

						<?php } ?>

						<button type="submit" name="reset" class="dashboard-list__button" value="<?= $student->id ?>" onclick="return confirm('Confermi di voler generare una nuova password per questo alunno/a?')">Reset della password</button>

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
<p class="stitle txt-1rem mar-t-3 pad-h-2 fa-center">
	Qui puoi controllare la lista degli studenti e dei corrispettivi username.<br>
	Se uno studente si registrasse per errore più di una volta, o se vedessi nella lista uno studente che non fa parte della tua classe, puoi disabilitarlo cliccando su <strong>disattiva</strong>.<br>
	Se invece uno studente si dimenticasse l'username, puoi verificare nella lista qual è e comunicarglielo.
</p>

<!-- Print -->
<div class="grid-flow center-content">
	<div class="button mar-t-3 js-print">
		<?= embed_icon('print') ?>
		Stampa
	</div>
</div>

{% end dashboard-body %}