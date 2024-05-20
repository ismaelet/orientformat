{% block main %}

<!-- Slider -->
<section id="slider">

	<div id="bgr-img" class="bgr" <?= background_image('/pages/assets/teacher/bgr.png') ?>></div>

</section>

<!-- Content -->
<section class="main-wrap pad-b-5">

	<!-- Title -->
	<div class="title-box mar-t-4 fa-center">

		<h1 class="title txt-25rem txt-sbold">Lista degli studenti</h1>

		<p class="stitle txt-1rem mar-t-1">
			Qui puoi controllare la lista degli studenti e dei corrispettivi username.<br><br>
			Se uno studente si registrasse per errore più di una volta, o se vedessi nella lista uno studente che non fa parte della tua classe, puoi disabilitarlo cliccando su <strong>disattiva</strong> nella riga corrispondente all'account da disabilitare.<br><br>
			Se uno studente si dimenticasse la password, puoi usare il bottone <span class="font-bold">reset password</span> nella riga corrispondente per impostarne una nuova.<br>
			Se invece uno studente si dimenticasse l'username, puoi scoprire nella lista qui sotto qual è e comunicarglielo.
		</p>

		<a href="<?= client_url('/teacher') ?>" class="button button--secondary back">Torna alla gestione</a><br>

	</div>

	<?php if ($students->num_rows) { ?>

		<?php if (DateTime::createFromFormat('Y-m-d', date('Y-m-d')) < DateTime::createFromFormat('Y-m-d', '2022-03-07')) { ?>

			<p id="warning">
				A differenza di quanto comunicato nell'incontro di presentazione, gli studenti saranno accettati <strong>automaticamente</strong>. Se per qualche motivo volessi disabilitare uno studente potrai comunque farlo usando il bottone <strong>disattiva</strong>
			</p>

		<?php } ?>

		<!-- List -->
		<div id="list" class="panel mar-t-3">
			<div class="list">

				<div class="head">
					<p class="field field-l">Username</p>
					<p class="field field-l">Cognome</p>
					<p class="field field-l">Nome</p>
					<p class="field field-l">Registrato il</p>
					<p class="field field-s">Attivo</p>
					<p class="field field-btn"></p>
				</div>

				<?php while ($student = $students->fetch_assoc()) { ?>

					<form method="POST" action="#row<?= $student['id'] ?>" id="row<?= $student['id'] ?>" class="row">

						<p class="field"><?= $student['username'] ?></p>
						<p class="field"><?= $student['lastname'] ?></p>
						<p class="field"><?= $student['firstname'] ?></p>
						<p class="field"><?= $student['time'] ?></p>
						<p class="field"><?= $student['status'] ? '<strong>SI</strong>' : 'NO' ?></p>

						<div class="field btn-box">
							<?php if ($student['status']) { ?>
								<button type="submit" name="deactivate" class="btn red">Disattiva</button>
							<?php } else { ?>
								<button type="submit" name="activate" class="btn gre">Attiva</button>
							<?php } ?>

							<button type="submit" name="reset" class="btn blu" onclick="return confirm('Sei sicuro/a di voler reimpostare la password dello studente?')">Reset password</button>

						</div>

						<input type="hidden" name="id" value="<?= $student['id'] ?>">

					</form>

				<?php } ?>

			</div>
		</div>

		<!-- Print -->
		<div class="fa-center">
			<div class="printbuttonmar-t-3">
				<span class="text-icon bgr-wht" <?= icon_svg('print') ?>></span>
				<span class="btn-text">Stampa</span>
			</div>
		</div>

	<?php } else { ?>

		<!-- Empty -->
		<div class="empty">
			<p>Non ci sono studenti registrati in questa classe.</p>
		</div>

	<?php } ?>

</section>

{% end main %}