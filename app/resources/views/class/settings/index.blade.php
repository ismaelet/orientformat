@pushOnce('scripts')
	@if ($class->isHighschool())
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
	@endif
@endpushOnce

<x-layouts.class-dashboard :$class>

	<div class="center-content grid">
		<form
			class="dashboard-panel fa-left"
			method="POST"
			action="{{ route('class.settings.update', $class) }}"
		>
			@csrf
			<x-heading.section class="mb-8 text-center">Impostazioni della classe</x-heading.section>

			<div
				class="form-body gap2 grid"
				x-data
			>

				@session('success')
					<x-alerts.success>{{ session('success') }}</x-alerts.success>
				@endsession

				<x-form.field>
					<x-label>Codice della classe</x-label>
					<p>Il codice della classe è generato automaticamente ed è importante comunicarlo ai propri studenti, in quanto è
						richiesto durante la procedura di registrazione. Clicca per copiare.</p>
					<p
						class="group mx-auto mt-4 w-fit cursor-pointer text-center text-2xl font-bold"
						title="Clicca per copiare"
						@click="navigator.clipboard.writeText('{{ $class->code }}'); $el.setAttribute('data-copied', 'true'); setTimeout(() => { $el.setAttribute('data-copied', 'false'); }, 4000);"
						data-copied="false"
					>
						{{ $class->code }}
						<x-icon-copy class="inline h-6 w-6 group-data-[copied=true]:hidden" />
						<x-icon-correct class="text-success-500 inline h-6 w-6 group-data-[copied=false]:hidden" />
					</p>
				</x-form.field>

				@if ($class->isMiddleschool())
					<x-form.field>
						<x-label>La classe è al</x-label>
						<x-select
							name="grade"
							:value="$class->grade()->absolute_number"
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
							:value="$class->letter"
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
							:value="$class->school->id"
							:options="[$class->school->id => $class->school->name]"
							readonly
						>
						</x-select>
					</x-form.field>
				@else
					<x-form.field>
						<x-label>Nome della classe</x-label>
						<p>Nome della classe, ad es. "3BS", "L1B" o "A4F".</p>
						<x-input
							name="letter"
							:value="$class->letter"
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
							:value="$class->grade()->absolute_number"
							:options="[4 => 'Primo anno', 5 => 'Secondo anno', 6 => 'Terzo anno', 7 => 'Quarto anno', 8 => 'Quinto anno']"
							disabled
						>
						</x-select>
						<input
							type="hidden"
							name="grade"
							value="{{ $class->grade()->absolute_number }}"
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
							:checked="!$class->isProfessional()"
						/>
						<x-checkbox
							type="radio"
							name="professional"
							text="Istituto di Istruzione e Formazione Professionale"
							:checked="$class->isProfessional()"
						/>
					</x-form.field>

					<x-form.field>
						<x-label>Istituto</x-label>
						<x-select
							name="schoolId"
							:value="$class->school->id"
							:options="[$class->school->id => $class->school->name]"
							required
							readonly
						>
						</x-select>
					</x-form.field>
				@endif

				@error('duplicate')
					<x-alerts.error>{{ $message }}</x-alerts.error>
				@enderror
			</div>

			<div class="mt-4 grid grid-cols-1 justify-items-center">
				<div class="grid grid-cols-1 gap-2">
					<x-button
						type="submit"
						class="center-icon"
					>
						<x-icon-save />
						Salva</x-button>

					@if (!$class->students->count())
						<x-button
							type="submit"
							class="center-icon"
							variant="secondary"
							color="danger"
							formaction="{{ route('class.delete', $class) }}"
						>
							<x-icon-delete />
							Elimina la classe</x-button>
					@endif
				</div>
			</div>
		</form>
	</div>

</x-layouts.class-dashboard>
