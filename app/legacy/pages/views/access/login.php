{% block main %}

<div class="page-body grid js-page-content <?= isset($_GET['register']) ? 'register-page' : '' ?>">

	<!-- Images -->
	<div class="images grid stack-content">
		<div class="page-background page-background--login" <?= background_image($loginType . '-login-image') ?>>
			<p class="page-background__title">Login</p>
		</div>

		<!-- Register image -->
		<div class="page-background page-background--register" <?= background_image($loginType . '-register-image') ?>>
			<p class="page-background__title">Registrati</p>
		</div>
	</div>

	<!-- Forms -->
	<div class="forms grid stack-content">

		<!-- Login form -->
		<form class="form form--login" method="POST" action="<?= route('login.auth') ?>" autocomplete="off">
			<div class="form__header">
				<h2 class="form__title">Accesso <?= $loginType == $studentType ? 'studente' : 'insegnante' ?></h2>
			</div>

			<div class="form__body">
				<input type="hidden" name="url" value="<?= $_GET['url'] ?? null ?>">

				<div class="special-input">
					<input type="text" name="login" id="username" placeholder="Username o email" required autocomplete="off">
					<?= embed_icon('user') ?>
				</div>

				<div class="special-input">
					<input type="password" name="password" placeholder="Password" required autocomplete="off">
					<?= embed_icon('password') ?>
				</div>

				<?php if (isset($_GET['error']) && $_GET['error'] == 'login_failed') { ?>

					<p class="error-warning">Dati di accesso errati</p>

				<?php } ?>

				<p class=""><a class="text-link" href="<?= route('auth.recover') ?>">Hai dimenticato i dati di accesso?</a></p>
			</div>

			<div class="form__footer">
				<button type="submit" class="button button--full-width">Login</button>
				<p class="form__divider ff-titles">oppure</p>
				<div class="button button--secondary button--full-width js-switch-form">Registrati
				</div>
				<a class="button button--secondary button--full-width" href="?login-type=<?= $loginType == $studentType ? $teacherType : $studentType ?>">Accedi come <?= $loginType == $studentType ? 'insegnante' : 'studente' ?></a>
			</div>
		</form>

		<!-- Register form -->
		<form class="form form--register" method="POST" action="<?= route('register.store') ?>" autocomplete="off">
			<input type="hidden" name="type" value="<?= $loginType ?>">
			<div class="form__header">
				<h2 class="form__title">Registrazione <?= $loginType == $studentType ? 'studente' : 'insegnante' ?></h2>
			</div>

			<div class="form__body">
				<!-- First and last name -->
				<div class="form__field">
					<input type="text" name="first_name" class="input" placeholder="Nome" value="<?= $_POST['first_name'] ?? '' ?>" maxlength="16" required autocomplete="off">
					<input type="text" name="last_name" class="input" placeholder="Cognome" value="<?= $_POST['last_name'] ?? '' ?>" maxlength="16" required autocomplete="off">

					<?php if ($error == 'duplicate-name') { ?>

						<p class="error-warning">Esiste già un account con questo nome e cognome registrato a questa classe.</p>

					<?php } ?>

				</div>

				<!-- Password -->
				<div class="form__field">
					<input type="password" name="password" class="inp-nospace input" placeholder="Password" maxlength="30" required autocomplete="off">
					<input type="password" name="cpassword" class="inp-nospace input" placeholder="Conferma password" maxlength="30" required autocomplete="off">

					<?php if ($error == 'password-short') { ?>

						<p class="error-warning">La password deve avere almeno 8 caratteri</p>

					<?php } ?>

					<?php if ($error == 'password-match') { ?>

						<p class="error-warning">Le due password non coincidono</p>

					<?php } ?>

				</div>

				<!-- Email -->
				<div class="form__field">
					<input type="email" name="email" class="inp-nospace input" placeholder="Indirizzo email" required autocomplete="off">

					<?php if ($error == 'duplicate-email') { ?>

						<p class="error-warning">Esiste già un account associato a questo indirizzo email</p>

					<?php } ?>

					<?php if ($error == 'invalid-email') { ?>

						<p class="error-warning">Indirizzo email non supportato. Per vedere la lista dei domini email supportati dalla piattaforma clicca <a class="font-bold" href="<?= route('help', ['category' => 1, 'topic' => 11]).'#topic11' ?>">qui</a></p>

					<?php } ?>

				</div>

				<?php if ($loginType == $studentType) { ?>

					<!-- Class code -->
					<div class="form__field">
						<input type="text" name="class" class="inp-nospace input" placeholder="Codice della classe" value="<?= $_POST['class'] ?? '' ?>" required autocomplete="off">

						<?php if ($error == 'class-wrong') { ?>

							<p class="error-warning">Codice della classe non riconosciuto</p>

						<?php } ?>

					</div>

					<!-- Birthdate -->
					<div class="form__field">
						<p class="label">Data di nascita:</p>
						<input type="date" name="birthdate" class="inp-nospace input" required autocomplete="off" min="<?= date('Y-m-d', strtotime('-100 year')) ?>" max="<?= date('Y-m-d', strtotime('-9 year')) ?>">
					</div>

				<?php } ?>

				<div class="form__field">
					<p>Hai già un account? <span class="text-link js-switch-form">Entra qui</span></p>
				</div>
			</div>

			<div class="form__footer">
				<button type="submit" class="button button--full-width" name="register">Registrati</button>
				<a class="button button--secondary button--full-width" href="?register=true&login-type=<?= $loginType == $studentType ? $teacherType : $studentType ?>">Registrati come <?= $loginType == $studentType ? 'insegnante' : 'studente' ?></strong></a>
			</div>
		</form>
	</div>
</div>

{% end main %}