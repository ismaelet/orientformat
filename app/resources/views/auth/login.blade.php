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
	<script defer>
		function changePage(isRegister) {
			// Change url
			const urlParams = new URLSearchParams(window.location.search);

			if (!isRegister) {
				urlParams.delete('register');
			} else {
				urlParams.set('register', 'true');
			}

			history.replaceState(null, '', `${window.location.pathname}?${urlParams.toString()}`);

			// Change Alpine state
			const root = document.querySelector('#page-root');

			if (root && root._x_dataStack) {
				root._x_dataStack[0].register = isRegister;
			}
		}

		function changeType(type) {
			// Change url
			const urlParams = new URLSearchParams(window.location.search);

			urlParams.set('login-type', type);

			history.replaceState(null, '', `${window.location.pathname}?${urlParams.toString()}`);

			// Change Alpine state
			const root = document.querySelector('#page-root');

			if (root && root._x_dataStack) {
				root._x_dataStack[0].type = type;
			}

			const typeInput = document.querySelector('input[name="type"]');

			if (typeInput) {
				typeInput.value = type;
			}
		}
	</script>
@endpushOnce

<x-layouts.legacy-main
	:$title
	:$location
>

	<div
		class="page-body js-page-content span-full-width group grid"
		x-data="{ type: '{{ $loginType }}', register: {{ $register ? 'true' : 'false' }} }"
		id="page-root"
		:data-page="register ? 'register' : 'login'"
		:data-type="type"
		x-cloak
	>

		{{-- Images --}}
		<div class="images stack-content grid">
			{{-- Login image --}}
			<img
				class="page-background page-background--login background-image login-only"
				src="{{ Vite::image('login/student-login-image.webp') }}"
				data-direction="left"
			>
			<p
				class="page-background__title login-only"
				data-direction="left"
			>Login</p>

			{{-- Register images --}}
			<img
				class="page-background page-background--register background-image register-only student-only"
				src="{{ Vite::image('login/student-register-image.webp') }}"
				data-direction="left"
			>
			<img
				class="page-background page-background--register background-image register-only teacher-only"
				src="{{ Vite::image('login/teacher-register-image.webp') }}"
				data-direction="left"
			>
			<p
				class="page-background__title register-only"
				data-direction="left"
			>Registrati</p>
		</div>

		<!-- Forms -->
		<div class="forms stack-content grid">

			<!-- Login form -->
			<form
				class="form form--login login-only"
				method="POST"
				action="{{ route('login.auth') }}"
				autocomplete="off"
				data-direction="right"
			>
				@csrf

				<div class="form__header">
					<x-heading.section class="text-center">Accedi a<br>OrientFormat</x-heading.section>
				</div>

				<div class="form__body">
					<x-input.open
						type="text"
						name="email"
						placeholder="Indirizzo e-mail"
						required
						autocomplete="off"
						class="w-full"
					/>

					<x-input.open-password
						type="password"
						name="password"
						placeholder="Password"
						required
						autocomplete="off"
						class="w-full"
					/>

					@error('password')
						<x-alerts.error :$message />
					@enderror

					@error('email')
						<x-alerts.error :$message />
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
						variant="secondary"
						@click="changePage(true); changeType('student')"
					>Registrati come studente
					</x-button>

					<x-button
						variant="secondary"
						@click="changePage(true); changeType('teacher')"
					>Registrati come docente</x-button>
				</div>
			</form>

			<!-- Register form -->
			<form
				class="form form--register register-only"
				method="POST"
				action="{{ route('register.store') }}"
				autocomplete="off"
				data-direction="right"
			>
				@csrf
				<input
					type="hidden"
					name="type"
					:value="type"
				>
				<div class="form__header text-center">
					<x-heading.section x-text="'Registrazione ' + (type == 'student' ? 'studente' : 'docente')"></x-heading.section>
				</div>

				<div class="form__body">
					@error('type')
						<x-alerts.error
							:$message
							class="mb-4"
						/>
					@enderror

					<p
						class="text-error-400"
						x-show="type == 'student'"
					>Se ti sei registrato/a in passato, per esempio in un'altra classe o un'altra scuola,
						<strong>NON</strong> creare un nuovo account, ma chiedi al/alla tuo/a docente di spostarti nella nuova classe
						seguendo la procedura indicata <a
							href="{{ route('help', ['category' => 5, 'topic' => 13]) }}#topic13"
							class="text-secondary-400 font-semibold"
						>qui</a>, oppure contattaci usando il formulario <a
							href="{{ route('help.ticket.open') }}"
							class="text-secondary-400 font-semibold"
						>qui</a>.
					</p>

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

						@error('name')
							<x-alerts.error :$message />
						@enderror

						@error('first_name')
							<x-alerts.error :$message />
						@enderror

						@error('last_name')
							<x-alerts.error :$message />
						@enderror

					</div>

					<!-- Password -->
					<div class="form__field">
						<x-input.password
							type="password"
							name="password"
							class="inp-nospace input"
							placeholder="Password"
							maxlength="30"
							required
							autocomplete="off"
						/>
						<x-input.password
							type="password"
							name="password_confirmation"
							class="inp-nospace input"
							placeholder="Conferma password"
							maxlength="30"
							required
							autocomplete="off"
						/>

						@error('password')
							<x-alerts.error :$message />
						@enderror

						@error('password_confirmation')
							<x-alerts.error :$message />
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
							<x-alerts.error :$message />
						@enderror

					</div>

					<!-- Class code -->
					<div class="form__field">
						<x-input
							type="text"
							name="class"
							class="inp-nospace input"
							placeholder="Codice della classe"
							value="{{ old('class') }}"
							autocomplete="off"
							x-bind:required="type == 'student' ? true : false"
							x-show="type == 'student'"
						/>

						@error('class')
							<x-alerts.error :$message />
						@enderror

					</div>

					<!-- Birthdate -->
					<div
						class="form__field"
						x-show="type == 'student'"
					>
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
							x-bind:required="type == 'student' ? true : false"
						/>

						@error('birthdate')
							<x-alerts.error :$message />
						@enderror
					</div>

					<div class="form__field">
						<p>Hai già un account? <span
								class="text-link"
								@click="changePage(false)"
							>Entra qui</span></p>
					</div>
				</div>

				<div class="form__footer">
					<x-button
						type="submit"
						name="register"
					>Registrati</x-button>

					<x-button
						variant="secondary"
						x-text="type == 'student' ? 'Registrati come docente' : 'Registrati come studente'"
						@click="changeType(type == 'student' ? 'teacher' : 'student')"
					></x-button>
				</div>
			</form>
		</div>
	</div>
</x-layouts.legacy-main>
