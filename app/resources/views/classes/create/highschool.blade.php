@pushOnce('scripts')
	<script defer>
		document.addEventListener('DOMContentLoaded', function() {
			const schoolClassNameInput = document.querySelector('[name="letter"]');
			const gradeInput = document.querySelector('[name="grade"]');
			const visibleGradeInput = document.querySelector('[name="visible_grade"]');

			schoolClassNameInput.addEventListener('keyup', function() {
				select_grade();
			})

			gradeInput.addEventListener('input', function() {
				select_grade();
			})

			function select_grade() {
				const validGrades = [1, 2, 3, 4, 5];

				let relativeGrade = parseInt(schoolClassNameInput.value.replace(/[a-zA-Z]/g, ''));

				relativeGrade = validGrades.includes(relativeGrade) ? relativeGrade : 1;

				const fullGradeName = relativeGrade + 3;

				gradeInput.value = fullGradeName;
				visibleGradeInput.value = fullGradeName;
			}
		})
	</script>
@endpushOnce

<x-layouts.form
	:$title
	method="POST"
	action="{{ route('classes.store') }}"
>

	<x-slot name="body">

		<x-form.field>
			<x-label>Nome della classe</x-label>
			<p>Nome della classe, ad es. "3BS", "L1B" o "A4F".</p>
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
			<x-label>Anno di corso</x-label>
			<p>L'anno di corso della classe, calcolato automaticamente in base al nome fornito.</p>
			<x-select
				name="visible_grade"
				:value="old('grade')"
				:options="[4 => 'Primo anno', 5 => 'Secondo anno', 6 => 'Terzo anno', 7 => 'Quarto anno', 8 => 'Quinto anno']"
				disabled
			>
			</x-select>
			<input
				type="hidden"
				name="grade"
				value="{{ old('grade') }}"
				required
			>
		</x-form.field>

		<x-form.field>
			<x-label>La classe è iscritta in un</x-label>
			<x-checkbox
				type="radio"
				name="professional"
				text="Istituto Tecnico, Professionale o Liceo"
				value="0"
				checked
			/>
			<x-checkbox
				type="radio"
				name="professional"
				text="Istituto di Istruzione e Formazione Professionale"
				value="1"
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
