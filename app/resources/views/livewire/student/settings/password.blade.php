<form
	class="settings-form rounded-lg bg-neutral-50 p-8 shadow-lg"
	method="POST"
	wire:submit.prevent="save"
>
	@csrf
	<div class="mb-4 flex items-baseline justify-center gap-2">
		<x-icon-key class="h-5 shrink-0" />
		<x-heading.component-big>
			Modifica la password
		</x-heading.component-big>
	</div>

	@session('passwordSuccess')
		<x-alert
			type="success"
			class="mt-8"
		>{{ session('passwordSuccess') }}</x-alert>
	@endsession

	<div class="grid grid-cols-1 gap-4">
		<x-form.field>
			<x-label>Password attuale</x-label>
			<x-input
				type="password"
				name="currentPassword"
				placeholder="Password attuale"
				wire:model="currentPassword"
				required
			/>

			@error('currentPassword')
				<x-alerts.error>{{ $message }}</x-alerts.error>
			@enderror
		</x-form.field>

		<x-form.field>
			<x-label>Nuova password</x-label>
			<p>La nuova password deve contenere almeno 8 caratteri.</p>
			<x-input
				type="password"
				name="newPassword"
				placeholder="Nuova password"
				minlength="8"
				wire:model="newPassword"
				required
			/>

			@error('newPassword')
				<x-alerts.error>{{ $message }}</x-alerts.error>
			@enderror
		</x-form.field>

		<x-form.field>
			<x-label>Conferma nuova password</x-label>
			<x-input
				type="password"
				name="newPasswordConfirmation"
				placeholder="Conferma la nuova password"
				minlength="8"
				wire:model="newPasswordConfirmation"
				required
			/>

			@error('newPasswordConfirmation')
				<x-alerts.error>{{ $message }}</x-alerts.error>
			@enderror
		</x-form.field>
	</div>

	<div class="mt-8 flex justify-center">
		<x-button
			type="submit"
			variant="secondary"
		>Modifica</x-button>
	</div>

</form>
