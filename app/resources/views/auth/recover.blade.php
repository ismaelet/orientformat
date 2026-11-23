<x-layouts.form
	:title="$title"
	action="{{ route('auth.recover') }}"
	method="POST"
>

	<x-slot name="body">

		@if (!session('submitted'))

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
					href="https://www.iprase.tn.it/orientamento/help?category=2&topic=12#topic12"
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

		@else
			<p class="text-justify">
				Se esiste un account associato all'indirizzo indicato, riceverai un'email con le istruzioni per resettare
				la password. Se non la ricevi entro qualche minuto, controlla la cartella spam.
			</p>

			<p class="text-center text-lg font-bold">{{ session('email') }}</p>
		@endif

	</x-slot>

	<x-slot name="footer">

		@if (!session('submitted'))
			<x-button type="submit">Recupera i dati</x-button>
		@endif

		<x-button
			variant="secondary"
			:href="route('login')"
		>Indietro</x-button>

	</x-slot>

</x-layouts.form>
