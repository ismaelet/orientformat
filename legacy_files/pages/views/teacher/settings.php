{% block form-body %}

<section class="subform mar-t-1">
	<h2 class="section-title">
		<?= embed_icon('user') ?>
		I miei dati
	</h2>

	<div class="subform_body">
		<?php generate_form($dataInputs, false, $error, $done) ?>
	</div>

	<div class="subform_footer">
		<button type="submit" class="button  button--full-width" name="edit-data">Modifica</button>
	</div>
</section>

<section class="subform">
	<h2 class="section-title">
		<?= embed_icon('key') ?>
		Modifica la password
	</h2>

	<div class="subform_body">
		<?php generate_form($passwordInputs, false, $error, $done) ?>
	</div>

	<div class="subform_footer mar-b-2">
		<button type="submit" class="button  button--full-width" name="edit-password">Modifica</button>
	</div>

</section>

{% end form-body %}