<x-layouts.administrator-dashboard :school="$school">
	<div class="mb-12 grid grid-cols-1 gap-4">
		<x-heading.main>Gestione docenti</x-heading.main>
		<x-subheading.main>{{ $school->name }}</x-subheading.main>
	</div>

	<livewire:administrator.teacher.table :school="$school" />
</x-layouts.administrator-dashboard>
