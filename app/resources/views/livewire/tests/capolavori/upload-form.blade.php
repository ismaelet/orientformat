<div class="contents">


	<form
		{{-- wire:submit.prevent="save" --}}
		method="POST"
		action="{{ route('masterpieces.upload') }}"
		enctype="multipart/form-data"
		class="@if ($masterpieceCount >= 5) hidden @endif"
	>
		@csrf

		<x-heading.component-big class="mb-8 text-center">Carica un capolavoro</x-heading.component-big>

		<div class="grid grid-cols-1 gap-8 rounded-lg border border-slate-200 p-4 shadow-sm sm:p-8">

			<x-form.open-input
				class="text-center text-lg font-semibold text-neutral-700"
				placeholder="Inserisci il titolo del capolavoro"
				wire:model="title"
				name="title"
				required
			/>

			<div class="max-w-200 mx-auto grid w-full gap-12 lg:grid-cols-2">
				<x-form.field class="">
					<x-label>Nato in ambito</x-label>

					@foreach ($settings as $settingId => $setting)
						<x-checkbox
							type="radio"
							name="setting"
							value="{{ $settingId }}"
							text="{{ $setting }}"
							wire:model="setting"
						/>
					@endforeach
				</x-form.field>

				<x-form.field class="">
					<x-label>In modalità</x-label>

					@foreach ($modes as $modeId => $mode)
						<x-checkbox
							type="radio"
							name="mode"
							value="{{ $modeId }}"
							text="{{ $mode }}"
							wire:model="mode"
						/>
					@endforeach
				</x-form.field>
			</div>

			<div class="max-w-200 mx-auto grid w-full gap-12 lg:grid-cols-2">
				<x-form.field class="">
					<x-label>Tipologia di attività</x-label>

					@foreach ($types as $typeId => $type)
						<x-checkbox
							type="radio"
							name="type"
							value="{{ $typeId }}"
							text="{{ $type }}"
							wire:model="type"
						/>
					@endforeach
				</x-form.field>

				<div class="max-w-96">
					<x-form.field class="">
						<x-label>Competenza sviluppata</x-label>

						@foreach ($skills as $skillId => $skill)
							<x-checkbox
								type="radio"
								name="skill"
								value="{{ $skillId }}"
								text="{{ $skill }}"
								wire:model="skill"
							/>
						@endforeach
					</x-form.field>
				</div>
			</div>

			<div class="grid grid-cols-1 gap-2 text-center">
				<x-label>Seleziona il capolavoro (formato PDF, max 25MB)</x-label>
				<input
					type="file"
					name="file"
					accept=".pdf"
					class="rounded-sm border border-dashed border-neutral-300 px-2 py-3"
					wire:model="file"
					required
				/>

				@error('file')
					<x-alerts.error>
						{{ $message }}
					</x-alerts.error>
				@enderror
			</div>

			@if (!$uploaded)
				<x-button
					type="submit"
					class="center-icon"
				>
					<x-icon-upload />
					Carica capolavoro
				</x-button>
			@endif
		</div>
	</form>
</div>
