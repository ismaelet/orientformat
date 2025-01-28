<x-dashboard.form
	:title="$title"
	:type="$type"
>

	<x-slot name="body">
		<x-dashboard.form.panel title="Dati personali">

			<x-inputs.group>
				<x-inputs.label for="email">ID classe</x-inputs.label>
				<x-inputs.input
					name="schoolClassId"
					placeholder="ID Classe"
					value="{{ $record ? $record->school_class->id : '' }}"
				/>

				@error('schoolClassId')
					<x-alerts.input-warning>{{ $message }}</x-alerts.input-warning>
				@enderror
			</x-inputs.group>

		</x-dashboard.form.panel>
	</x-slot>

	<x-slot name="footer">
		<x-dashboard.form.save-button />
	</x-slot>

</x-dashboard.form>
