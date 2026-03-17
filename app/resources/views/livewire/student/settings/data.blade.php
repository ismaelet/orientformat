<form
	class="settings-form rounded-lg bg-neutral-50 p-8 shadow-lg"
	method="POST"
	wire:submit.prevent="save"
>
	@csrf
	<div class="mb-4 flex items-baseline justify-center gap-2">
		<x-icon-user class="h-4 shrink-0" />
		<x-heading.component-big>
			Modifica i miei dati
		</x-heading.component-big>
	</div>

	<div class="grid grid-cols-1 gap-4">
		@session('success')
			<x-alert
				type="success"
				class="mt-8"
			>{{ session('success') }}</x-alert>
		@endsession

		<x-form.field>
			<x-label>Nome</x-label>
			<div class="grid gap-[inherit] md:grid-cols-2">
				<x-input
					type="text"
					name="first_name"
					wire:model="firstName"
					required
				/>
				<x-input
					type="text"
					name="last_name"
					wire:model="lastName"
					required
				/>
			</div>

			@error('lastName')
				<x-alerts.error>{{ $message }}</x-alerts.error>
			@enderror

			@error('firstName')
				<x-alerts.error>{{ $message }}</x-alerts.error>
			@enderror
		</x-form.field>

		<x-form.field>
			<x-label>E-mail</x-label>
			<x-input
				type="email"
				name="email"
				wire:model="email"
				required
			/>

			@error('email')
				<x-alerts.error>{{ $message }}</x-alerts.error>
			@enderror
		</x-form.field>

		<div class="border-neutral-border field-group mt-4 grid grid-cols-1 gap-2 rounded border-2 p-4 xl:grid-cols-2">
			<x-form.field>
				<x-label>Istituto</x-label>
				<x-select
					name="schoolId"
					:options="$schools->pluck('name', 'id')"
					wire:model.live="schoolId"
					required
					placeholder="Seleziona un istituto"
				/>

				@error('schoolId')
					<x-alerts.error>{{ $message }}</x-alerts.error>
				@enderror
			</x-form.field>

			<x-form.field>
				<x-label>Classe</x-label>
				<x-select
					name="classId"
					:options="$classOptions"
					wire:model.live="classId"
					required
					:disabled="empty($classOptions)"
					placeholder="Seleziona una classe"
				/>

				@error('classId')
					<x-alerts.error>{{ $message }}</x-alerts.error>
				@enderror
			</x-form.field>

			<div class="{{ $this->classId && $this->classId != $this->student->schoolClassId ? '' : 'hidden' }} col-span-full">
				<p>Per confermare che puoi cambiare classe, inserisci il codice della nuova classe (deve essere fornito dal tutor):
				</p>

				<x-form.field class="">
					<x-input
						type="text"
						name="class_code"
						wire:model="classCode"
						placeholder="Codice classe della nuova classe"
					/>

					@error('classCode')
						<x-alerts.error>{{ $message }}</x-alerts.error>
					@enderror
				</x-form.field>
			</div>
		</div>
	</div>

	<div class="mt-8 flex justify-center">
		<x-button type="submit">Modifica</x-button>
	</div>
</form>
