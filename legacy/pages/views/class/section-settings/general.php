{% block dashboard-body %}

<div class="grid-flow center-content">
	<form class="dashboard-panel fa-left" method="POST">
		<h1 class="dashboard-panel__title center-content">Impostazioni della classe</h1>

		<div class="form-body grid gap2">
			<?= generate_form($inputs, false, $error, $done) ?>

			<div class="form-field">
				<p class="form-lbl">Codice della classe</p>
				<p>Il codice della classe è generato automaticamente ed è importante comunicarlo ai propri studenti, in quanto è richiesto durante la procedura di registrazione</p>
				<input type="text" class="inp" value="<?= schoolClass()->code ?>" readonly>
			</div>

			<!-- End review -->
			<?php if (in_array(schoolClass()->grade->id, [3, 7, 8, 9, 10])) { ?>

				<div class="">
					<p class="form-lbl">Questionario finale</p>
					<p>Quando i tuoi studenti averanno finito tutte le attività, attiva qui sotto il questionario finale.</p>
					<label class="toggle-switch toggle-switch_rg mar-t-1">
						<input type="checkbox" name="survey-end" <?= schoolClass()->ended ? 'checked' : '' ?>>
						<div class="toggle-switch_bgr">
							<div class="icon"></div>
						</div>
						<p>Questionario finale</p>
					</label>
				</div>

			<?php } ?>

		</div>

		<div class="form-footer mar-t-2 grid-flow center-content" data-spacing="400">
			<button class="button" name="submit">Salva</button>

			<?php if (!$schoolClass->students->count()) { ?>

				<button class="button button--secondary button--bad" name="delete">Elimina la classe</button>

			<?php } ?>

		</div>
	</form>
</div>

{% end dashboard-body %}