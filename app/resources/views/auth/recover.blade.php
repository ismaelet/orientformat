<x-layouts.form
	:title="$title"
	action="{{ route('auth.recover') }}"
	method="POST"
>

	<x-slot name="body">

		@if (!session('submitted') || session('not_found'))

			{{-- Show instructions to recover the account --}}
			<p class="text-justify">
				Inserisci l'indirizzo email associato al tuo account e ti manderemo un'email con le istruzioni per
				resettare la password.
			</p>

			<p class="text-danger-500">In caso tu sia uno/a <strong>studente/studentessa</strong>, è possibile che tu non possa
				ricevere l'email di
				recupero, in quanto gli indirizzi email d'Istituto spesso bloccano le email provenienti da domini esterni.<br><br>In
				questo caso dovresti contattare il/la tuo/a docente e chiedere di effettuare un reset della password seguendo le
				istruzioni indicate <a
					class="text-secondary-400 font-bold"
					href="https://www.iprase.tn.it/orientamento/help?category=5&topic=12#topic12"
				>qui</a>.</p>

			{{-- Email input --}}
			<x-input
				type="email"
				name="email"
				placeholder="Indirizzo email"
				:value="session('email') ?: ''"
				required
			/>

			@if ($errors->has('email'))
				<x-alerts.error class="mt-4">
					{{ $errors->first('email') }}
				</x-alerts.error>
			@endif

			@if (session('mail_error'))
				<x-alerts.error class="mt-4">
					{{ session('mail_error') }}
				</x-alerts.error>
			@endif

			{{-- If the form hasn't been submitted or the email is not found --}}
			@if (session('not_found'))
				{{-- Show error message if email is not found --}}
				<x-alerts.error class="mt-4">
					Non abbiamo trovato nessun account associato all'indirizzo email indicato
				</x-alerts.error>
			@endif
		@else
			{{-- If the email is found --}}
			<p class="text-justify">Abbiamo mandato un'email con le istruzioni per resettare la password
				all'indirizzo qui sotto. Se non dovessi ricevere l'email entro qualche minuto, controlla la cartella di
				spam.
			</p>

			<p class="text-center text-lg font-bold">{{ session('email') }}</p>
		@endif

	</x-slot>

	<x-slot name="footer">

		@if (!session('submitted') || session('not_found'))
			{{-- If the form hasn't been submitted or the email is not found --}}
			<x-button type="submit">Recupera i dati</x-button>
		@endif

		<x-button
			variant="secondary"
			:href="route('login')"
		>Indietro</x-button>

	</x-slot>

</x-layouts.form>
