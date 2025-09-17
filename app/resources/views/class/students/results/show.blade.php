<x-layouts.class-dashboard :$class>

	<div
		class="dashboard-header grid grid-cols-1 justify-items-center gap-8 text-center"
		x-data
	>
		<div class="">
			<x-subheading.main>progresso di</x-subheading.main>
			<x-heading.main><?= $student->inverted_full_name ?>
			</x-heading.main>
		</div>

		<p class="section-subtitle">Qui puoi monitorare il progresso dello studente/studentessa diviso per
			attività.<br>Clicca
			sul punto informativo che puoi trovare alla fine di ogni riga per mostrare l'interpretazione del risultato
			relativo.
		</p>

		<div class="grid grid-cols-1 gap-4">
			<x-button
				href="{{ route('students.results.pdf', ['student' => $student]) }}"
				class="center-icon btn-print"
			>
				<x-icon-download />
				Scarica come PDF
			</x-button>

			<x-button
				href="{{ route('class.students.results.index', ['class' => $class, 'student' => $student]) }}"
				variant="secondary"
			>
				Indietro
			</x-button>
		</div>
	</div>

	<x-class-dashboard.student-result.page
		:$student
		:$reviewResults
		:$grades
	/>
</x-layouts.class-dashboard>
