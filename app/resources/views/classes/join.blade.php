<x-layouts.form
	:$title
	method="POST"
	action="{{ route('classes.join.store') }}"
>

	<x-slot name="body">
		@if (!$class)
			<p>Scegli la classe a cui vuoi partecipare alla gestione:</p>

			<div class="hidden">
				<x-form.field class="">
					<x-label>Istituto</x-label>
					<x-select
						name="schoolId"
						:value="old('schoolId')"
						:options="[$school->id => $school->name]"
						required
					/>
				</x-form.field>
			</div>

			<x-form.field class="">
				<x-select
					name="class_id"
					:value="old('class_id')"
					:options="$classes"
					required
				/>
			</x-form.field>
		@else
			<p>Abbiamo inviato la richiesta di collaborazione a <strong><?= $class->referent?->full_name ?></strong>. Per
				favore, attendi che la richiesta sia accettata per poter cominciare a contribuire alla gestione della classe.</p>
		@endif
	</x-slot>

	<x-slot name="footer">
		@if (!$class)
			<x-button type="submit">Aggiungi</x-button>
			<x-button
				href="{{ route('classes.create') }}"
				variant="secondary"
			>Indietro</x-button>
		@else
			<x-button
				href="{{ route('teacher.dashboard') }}"
				variant="secondary"
			>Torna alla dashboard</x-button>
		@endif
	</x-slot>

</x-layouts.form>
