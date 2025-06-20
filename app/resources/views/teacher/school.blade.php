<x-layouts.form
	:$title
	method="POST"
	action="{{ route('teacher.school.store') }}"
>
	<x-slot name="body">
		<p>
			Seleziona il nome dell'istituto dove stai lavorando al momento. Potrai cambiarla nel pannello <span
				class="text-strong"
			>Impostazioni account</span> quando vorrai.
		</p>

		<x-select
			name="school_id"
			required
		>
			<option
				disabled
				selected
			>Seleziona un istituto</option>

			@foreach ($schools as $school)
				<option value="{{ $school->id }}">{{ $school->name }}</option>
			@endforeach
		</x-select>
	</x-slot>

	<x-slot name="footer">
		<x-button type="submit">Seleziona</x-button>
	</x-slot>
</x-layouts.form>
