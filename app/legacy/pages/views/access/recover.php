{% block form-body %}

<?php if (!$submitted || !$found) { ?>
	<?php if ($submitted) { ?>
		<p class="error-warning">Non abbiamo trovato nessun account associato all'indirizzo email indicato</p>
	<?php } ?>

	<p class="py-4 txt-1rem txt-jus">
		Inserisci l'indirizzo email associato al tuo account e ti manderemo un'email con le istruzioni per resettare la password.
	</p>

	<input type="email" class="inp" name="email" placeholder="Indirizzo email" value="<?= $_POST['email'] ?? '' ?>" required>
<?php } else { ?>
	<p class="mar-t-1 txt-1rem">Abbiamo mandato un'email con le istruzioni per resettare la password all'indirizzo:</p>
	<p class="mb-4 font-bold txt-12rem fa-center"><?= $email ?></p>
<?php } ?>

{% end form-body %}

{% block form-footer %}

<?php if (!$submitted || !$found) { ?>
	<button type="submit" name="submit" class="button">Recupera l'account</button>
<?php } ?>

<a href="<?= client_url('/') ?>" class="button button--secondary"><?= __('Back') ?></a>

{% end form-footer %}