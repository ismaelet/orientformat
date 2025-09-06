<x-layouts.administrator-dashboard :school="$school">
	<div class="mb-12 grid grid-cols-1 gap-4">
		<x-heading.main>Gestione studenti</x-heading.main>
		<x-subheading.main>{{ $school->name }}</x-subheading.main>
	</div>

	<livewire:administrator.student.table :school="$school" />
</x-layouts.administrator-dashboard>
