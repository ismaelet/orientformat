<x-layouts.form
	:title="$title"
	action="{{ route('auth.reset') }}"
	method="POST"
>

	<x-slot name="body">

		@if (session('submitted'))
			<p class="text-green-600">Password cambiata con successo!</p>
		@elseif (session('error'))
			<p class="text-red-600">Il link di rest non è valido o è scaduto</p>
		@else
			<p class="">
				Inserisci qui sotto la nuova password desiderata:
			</p>

			<x-input
				type="hidden"
				name="token"
				:value="$token"
			/>
			<x-input
				type="hidden"
				name="email"
				:value="$email"
			/>
			<x-input
				type="password"
				name="password"
				placeholder="Nuova password"
				required
			/>
			<x-input
				type="password"
				name="password_confirmation"
				placeholder="Conferma la nuova password"
				required
			/>

			@error('password')
				<x-alerts.error>{{ $message }}</x-alerts.error>
			@enderror
		@endif

	</x-slot>

	<x-slot name="footer">

		@if (session('error'))
			<x-button
				variant="secondary"
				href="{{ route('auth.recover') }}"
			>Richiedi un nuovo codice</x-button>
		@else
			@if (!session('submitted'))
				<x-button type="submit">Reimposta la password</x-button>
			@endif

			<x-button
				variant="secondary"
				:href="route('login')"
			>Torna al login</x-button>
		@endif

	</x-slot>

</x-layouts.form>
