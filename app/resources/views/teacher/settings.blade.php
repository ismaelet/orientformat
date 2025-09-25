<x-layouts.legacy-main>

	<div class="w-200 mx-auto">
		<form
			class="mt-12 rounded-lg bg-neutral-50 p-8 shadow-lg"
			method="POST"
			action="{{ route('teacher.settings.update') }}"
		>
			@csrf
			<div class="flex items-baseline justify-center gap-2">
				<x-icon-user class="h-6" />
				<x-heading.section>
					I miei dati
				</x-heading.section>
			</div>

			<div class="grid grid-cols-1 gap-4">
				@session('success')
					<x-alerts.success class="mt-8">{{ session('success') }}</x-alerts.success>
				@endsession

				<x-form.field>
					<x-label>Nome</x-label>
					<div class="grid gap-[inherit] md:grid-cols-2">
						<x-input
							type="text"
							name="first_name"
							value="{{ old('first_name', $teacher->user->first_name) }}"
							required
						/>
						<x-input
							type="text"
							name="last_name"
							value="{{ old('last_name', $teacher->user->last_name) }}"
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
						value="{{ old('email', $teacher->user->email) }}"
						required
					/>

					@error('email')
						<x-alerts.error>{{ $message }}</x-alerts.error>
					@enderror
				</x-form.field>

				<x-form.field>
					<x-label>Istituto di appartenenza</x-label>
					<x-select
						name="school_id"
						:value="$teacher->school->id"
						:options="$schools->pluck('name', 'id')"
						required
						readonly
					/>

					@error('school_id')
						<x-alerts.error>{{ $message }}</x-alerts.error>
					@enderror
				</x-form.field>
			</div>

			<div class="mt-8 flex justify-center">
				<x-button type="submit">Modifica</x-button>
			</div>
		</form>

		<form
			class="mb-20 mt-12 rounded-lg bg-neutral-50 p-8 shadow-lg"
			method="POST"
			action="{{ route('teacher.password.update') }}"
		>
			@csrf
			<div class="flex items-baseline justify-center gap-2">
				<x-icon-key class="h-6" />
				<x-heading.section>
					Modifica la password
				</x-heading.section>
			</div>

			@session('passwordSuccess')
				<x-alerts.success class="mt-8">{{ session('passwordSuccess') }}</x-alerts.success>
			@endsession

			<div class="grid grid-cols-1 gap-4">
				<x-form.field>
					<x-label>Password attuale</x-label>
					<x-input
						type="password"
						name="current_password"
						placeholder="Password attuale"
						required
					/>

					@error('current_password')
						<x-alerts.error>{{ $message }}</x-alerts.error>
					@enderror
				</x-form.field>

				<x-form.field>
					<x-label>Nuova password</x-label>
					<p>La nuova password deve contenere almeno 8 caratteri.</p>
					<x-input
						type="password"
						name="new_password"
						placeholder="Nuova password"
						minlength="8"
						required
					/>

					@error('new_password')
						<x-alerts.error>{{ $message }}</x-alerts.error>
					@enderror
				</x-form.field>

				<x-form.field>
					<x-label>Conferma nuova password</x-label>
					<x-input
						type="password"
						name="new_password_confirmation"
						placeholder="Conferma la nuova password"
						minlength="8"
						required
					/>

					@error('new_password_confirmation')
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
	</div>

</x-layouts.legacy-main>
