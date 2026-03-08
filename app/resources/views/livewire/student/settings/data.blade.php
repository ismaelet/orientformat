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
					wire:model="firtsName"
					required
				/>
				<x-input
					type="text"
					name="last_name"
					wire:model="lastName"
					required
				/>
			</div>

			@error('last_name')
				<x-alerts.error>{{ $message }}</x-alerts.error>
			@enderror

			@error('first_name')
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
					name="school_id"
					:options="$schools->pluck('name', 'id')"
					wire:model.live="schoolId"
					required
				/>

				@error('school_id')
					<x-alerts.error>{{ $message }}</x-alerts.error>
				@enderror
			</x-form.field>

			<x-form.field>
				<x-label>Classe</x-label>
				<x-select
					name="class_id"
					:options="$classes->pluck('name_with_tutor', 'id')"
					wire:model="classId"
					required
				/>

				@error('school_id')
					<x-alerts.error>{{ $message }}</x-alerts.error>
				@enderror
			</x-form.field>
		</div>
	</div>

	<div class="mt-8 flex justify-center">
		<x-button type="submit">Modifica</x-button>
	</div>

	@if ($joinRequests->isNotEmpty())
		<div class="mt-8">
			<ul class="grid grid-cols-1 gap-2">
				@foreach ($joinRequests as $request)
					<li class="rounded bg-yellow-50 p-4">
						<p class="mb-2">La tua richiesta di cambio classe alla classe
							<strong>{{ $request->class?->name }}</strong> è in attesa di approvazione da parte del/della tutor
							<strong>{{ $request->class?->tutor?->inverted_full_name }}</strong>.
						</p>
						<p class="text-sm text-gray-600">Attendi che la richiesta sia accettata...</p>
					</li>
				@endforeach
			</ul>
		</div>
	@endif
</form>
