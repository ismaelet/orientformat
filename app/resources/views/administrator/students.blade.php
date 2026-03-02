<x-layouts.administrator-dashboard :school="$school">
	<div class="mb-12 grid grid-cols-1 gap-4">
		<x-heading.main>Gestione studenti</x-heading.main>
		<x-subheading.main>{{ $school->name }}</x-subheading.main>

		<p>Per eseguire modifiche, reset della password o altre operazioni, clicca sull'icona <svg
				class="inline-block h-5 w-5 text-amber-600"
				xmlns="http://www.w3.org/2000/svg"
				viewBox="0 0 20 20"
				fill="currentColor"
				aria-hidden="true"
				data-slot="icon"
			>
				<path
					d="M10 3a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM10 8.5a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM11.5 15.5a1.5 1.5 0 1 0-3 0 1.5 1.5 0 0 0 3 0Z"
				></path>
			</svg>

			a lato dello dello studente che vuoi modificare.
		</p>
	</div>

	<livewire:administrator.student.table :school="$school" />
</x-layouts.administrator-dashboard>
