{% block form-body %}

<?php if (!$done) { ?>
	<p class="pad-v-1 txt-1rem txt-jus">
		Inserisci qui sotto la nuova password desiderata:
	</p>

	<?php if ($error) { ?>
		<p class="error">Le password inserite non corrispondono</p>
	<?php } ?>

	<input type="password" class="inp" name="password" placeholder="Nuova password" required>
	<input type="password" class="inp" name="password-confirmation" placeholder="Conferma la password" required>

<?php } else { ?>
	<p class="txt-bold txt-cen pad-v-1">Password cambiata con successo!</p>
<?php } ?>

{% end form-body %}

{% block form-footer %}

<?php if (!$done) { ?>
	<button type="submit" name="submit" class="pbtn">Reimposta la password</button>
<?php } else { ?>
	<a href="<?= html_link('login') ?>" class="sbtn">Torna al login</a>
<?php } ?>

{% end form-footer %}