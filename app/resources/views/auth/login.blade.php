@pushOnce('styles')
	<link
		rel="stylesheet"
		href="{{ asset('css/legacy/login.css') }}"
	>
	<style>
		main {
			overflow: hidden;
		}
	</style>
@endpushOnce

@pushOnce('scripts')
	<script
		defer
		src="{{ asset('js/legacy/login.js') }}"
	></script>
@endpushOnce

<x-layouts.legacy-main
	:$title
	:$location
>

	<div
		class="page-body js-page-content <?= isset($_GET['register']) ? 'register-page' : 'login-page' ?> span-full-width grid"
	>

		<!-- Images -->
		<div class="images stack-content grid">
			<img
				class="page-background page-background--login background-image"
				src="{{ Vite::image('login/' . $loginType . '-login-image.webp') }}"
			>
			<p
				class="page-background__title"
				data-page="login"
			>Login</p>

			<!-- Register image -->
			<img
				class="page-background page-background--register background-image"
				src="{{ Vite::image('login/' . $loginType . '-register-image.webp') }}"
			>
			<p
				class="page-background__title"
				data-page="register"
			>Registrati</p>
		</div>

		<!-- Forms -->
		<div class="forms stack-content grid">

			<!-- Login form -->
			<form
				class="form form--login"
				method="POST"
				action="{{ route('login.auth') }}"
				autocomplete="off"
			>
				@csrf

				<div class="form__header">
					<h2 class="form__title">Accesso <?= $loginType == $studentType ? 'studente' : 'insegnante' ?></h2>
				</div>

				<div class="form__body">
					<input
						type="hidden"
						name="url"
						value="<?= $_GET['url'] ?? null ?>"
					>

					<div class="special-input">
						<input
							type="text"
							name="login"
							id="username"
							placeholder="Username o email"
							required
							autocomplete="off"
							class="w-full"
						>
						<x-icon-user class="h-4 w-4" />
					</div>

					<div class="special-input">
						<input
							type="password"
							name="password"
							placeholder="Password"
							required
							autocomplete="off"
							class="w-full"
						>
						<x-icon-password class="h-4 w-4" />
					</div>

					@error('password')
						<p class="error-warning">{{ $message }}</p>
					@enderror

					@error('login')
						<p class="error-warning">Username o password errati</p>
					@enderror

					<p class=""><a
							class="text-link"
							href="{{ route('auth.recover') }}"
						>Hai dimenticato i dati di accesso?</a></p>
				</div>

				<div class="form__footer">
					<x-button type="submit">Login</x-button>
					<p class="form__divider ff-titles">oppure</p>
					<x-button
						class="js-switch-form"
						variant="secondary"
					>Registrati
					</x-button>
					<x-button
						variant="secondary"
						href="?login-type={{ $loginType == $studentType ? $teacherType : $studentType }}"
					>Accedi come {{ $loginType == $studentType ? 'insegnante' : 'studente' }}</x-button>
				</div>
			</form>

			<!-- Register form -->
			<form
				class="form form--register"
				method="POST"
				action="<?= route('register.store') ?>"
				autocomplete="off"
			>
				@csrf

				<input
					type="hidden"
					name="type"
					value="<?= $loginType ?>"
				>
				<div class="form__header">
					<h2 class="form__title">Registrazione <?= $loginType == $studentType ? 'studente' : 'insegnante' ?></h2>
				</div>

				<div class="form__body">
					<!-- First and last name -->
					<div class="form__field">
						<x-input
							type="text"
							name="first_name"
							class="input"
							placeholder="Nome"
							value="{{ old('first_name') }}"
							maxlength="16"
							required
							autocomplete="off"
						/>
						<x-input
							type="text"
							name="last_name"
							class="input"
							placeholder="Cognome"
							value="{{ old('last_name') }}"
							maxlength="16"
							required
							autocomplete="off"
						/>

						@error('last_name')
							<p class="error-warning">{{ $message }}</p>
						@enderror

					</div>

					<!-- Password -->
					<div class="form__field">
						<x-input
							type="password"
							name="password"
							class="inp-nospace input"
							placeholder="Password"
							maxlength="30"
							required
							autocomplete="off"
						/>
						<x-input
							type="password"
							name="cpassword"
							class="inp-nospace input"
							placeholder="Conferma password"
							maxlength="30"
							required
							autocomplete="off"
						/>

						@error('password')
							<p class="error-warning">{{ $message }}</p>
						@enderror

					</div>

					<!-- Email -->
					<div class="form__field">
						<x-input
							type="email"
							name="email"
							class="inp-nospace input"
							placeholder="Indirizzo email"
							value="{{ old('email') }}"
							required
							autocomplete="off"
						/>

						@error('email')
							<p class="error-warning">{!! $message !!}</p>
						@enderror

					</div>

					<?php if ($loginType == $studentType) { ?>

					<!-- Class code -->
					<div class="form__field">
						<x-input
							type="text"
							name="class"
							class="inp-nospace input"
							placeholder="Codice della classe"
							value="{{ old('class') }}"
							required
							autocomplete="off"
						/>

						@error('class')
							<p class="error-warning">{{ $message }}</p>
						@enderror

					</div>

					<!-- Birthdate -->
					<div class="form__field">
						<p class="label">Data di nascita:</p>
						<x-input
							type="date"
							name="birthdate"
							class="inp-nospace input"
							value="{{ old('birthdate') }}"
							required
							autocomplete="off"
							min="{{ date('Y-m-d', strtotime('-100 year')) }}"
							max="{{ date('Y-m-d', strtotime('-9 year')) }}"
						/>
					</div>

					<?php } ?>

					<div class="form__field">
						<p>Hai già un account? <span class="text-link js-switch-form">Entra qui</span></p>
					</div>
				</div>

				<div class="form__footer">
					<x-button
						type="submit"
						name="register"
					>Registrati</x-button>
					<x-button
						variant="secondary"
						href="?register=true&login-type={{ $loginType == $studentType ? $teacherType : $studentType }}"
					>Registrati come {{ $loginType == $studentType ? 'insegnante' : 'studente' }}</x-button>
				</div>
			</form>
		</div>
	</div>
</x-layouts.legacy-main>
