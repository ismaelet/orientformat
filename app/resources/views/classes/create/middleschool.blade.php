<x-layouts.form
	:$title
	method="POST"
	action="{{ route('classes.store') }}"
>

	<x-slot name="body">
		<x-form.field>
			<x-label>La classe è al</x-label>
			<x-select
				name="grade"
				:value="old('grade')"
				:options="[1 => 'Primo anno', 2 => 'Secondo anno', 3 => 'Terzo anno']"
				required
			>
			</x-select>
		</x-form.field>

		<x-form.field>
			<x-label>Lettera identificativa della della classe</x-label>
			<p>Lettera che identifica la classe, ad es. se la classe è una 3B la lettera è "B", se è una 2A è "A", ecc.</p>
			<x-input
				name="letter"
				:value="old('letter')"
				placeholder="Lettera identificativa"
				maxlength="10"
				class="uppercase"
				required
			/>
		</x-form.field>

		<x-form.field>
			<x-label>Istituto</x-label>
			<x-select
				name="schoolId"
				:value="old('schoolId')"
				:options="[$school->id => $school->name]"
				required
			>
			</x-select>
		</x-form.field>

		@error('duplicate')
			<x-alert type="error">{{ $message }}</x-alert>
		@enderror

	</x-slot>

	<x-slot name="footer">
		<x-button type="submit">Aggiungi</x-button>

		<x-button
			variant="secondary"
			href="{{ route('classes.create') }}"
		>Indietro</x-button>
	</x-slot>
</x-layouts.form>
