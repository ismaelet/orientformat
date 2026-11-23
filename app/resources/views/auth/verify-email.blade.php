<x-layouts.form
	:title="$title"
	action="{{ route('verification.send') }}"
	method="POST"
>
	<x-slot name="body">
		@if (session('status') === 'verification-link-sent')
			<x-alerts.success>
				Un nuovo link di verifica è stato inviato al tuo indirizzo email.
			</x-alerts.success>
		@else
			<p class="text-justify">
				Verifica il tuo indirizzo email tramite il link che ti abbiamo inviato prima di usare le funzioni per docenti e
				amministratori.
			</p>
		@endif
	</x-slot>

	<x-slot name="footer">
		<x-button type="submit">Invia di nuovo la mail</x-button>
		<x-button
			variant="secondary"
			:href="route('logout')"
		>Esci</x-button>
	</x-slot>
</x-layouts.form>
