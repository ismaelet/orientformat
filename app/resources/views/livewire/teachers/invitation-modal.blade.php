<div>
	@if ($teachersNotInClass->isNotEmpty())
		<div
			class="mt-12 grid grid-cols-1 justify-items-center gap-4"
			x-data
		>

			@if (session('status'))
				<div class="text-green-600">
					{!! session('status') !!}
				</div>
			@endif

			<x-button
				variant="secondary"
				@click="openModal('invite-teacher-modal')"
			>Invita un/a docente</x-button>
		</div>

		<x-modal id="invite-teacher-modal">
			<x-modal.content>
				<form
					class="grid grid-cols-1 gap-8 p-4"
					method="POST"
					wire:submit="sendInvitation"
				>
					<x-heading.component-big class="text-center">Invita a collaborare</x-heading.component-big>
					<x-form.field>
						<x-label>Seleziona il/la docente da invitare alla collaborazione</x-label>
						<select
							class="name= rounded-sm border border-slate-300 px-3 py-2"
							required
							wire:model="invitedTeacherId"
						>
							<option value="">-- Seleziona un/a docente --</option>
							@foreach ($teachersNotInClass as $teacher)
								<option value="{{ $teacher->id }}">{{ $teacher->inverted_full_name }}</option>
							@endforeach
						</select>
					</x-form.field>

					<x-button type="submit">Invita</x-button>
				</form>
			</x-modal.content>
		</x-modal>
	@endif
</div>
