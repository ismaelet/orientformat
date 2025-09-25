<x-layouts.form
	:$title
	method="POST"
	action="{{ route('teacher.school.store') }}"
>
	<x-slot name="body">
		<p>
			Seleziona il nome dell'istituto di appartenenza. In caso di trasferimento ad un altro istituto, potrai cambiarlo nel
			pannello <span class="text-strong">Impostazioni account</span> quando vorrai.
		</p>

		<x-select
			name="school_id"
			required
		>
			<option
				disabled
				selected
			>Seleziona l'istituto</option>

			@foreach ($schools as $school)
				<option value="{{ $school->id }}">{{ $school->name }}</option>
			@endforeach
		</x-select>
	</x-slot>

	<x-slot name="footer">
		<x-button type="submit">Seleziona</x-button>
	</x-slot>
</x-layouts.form>
