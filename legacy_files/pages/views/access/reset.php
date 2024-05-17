{% block form-body %}

<?php if (!$done) { ?>
	<p class="pad-v-1 txt-1rem txt-jus">
		Inserisci qui sotto la nuova password desiderata:
	</p>

	<?php if ($error) { ?>
		<p class="error-warning">Le password inserite non corrispondono</p>
	<?php } ?>

	<input type="password" class="inp" name="password" placeholder="Nuova password" required>
	<input type="password" class="inp" name="password-confirmation" placeholder="Conferma la password" required>

<?php } else { ?>
	<p class="fw-bold fa-center pad-v-1">Password cambiata con successo!</p>
<?php } ?>

{% end form-body %}

{% block form-footer %}

<?php if (!$done) { ?>
	<button type="submit" name="submit" class="button">Reimposta la password</button>
<?php } else { ?>
	<a href="<?= client_url('/login') ?>" class="button button--secondary">Torna al login</a>
<?php } ?>

{% end form-footer %}