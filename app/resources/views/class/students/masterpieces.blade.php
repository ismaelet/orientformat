<x-layouts.class-dashboard :$class>

	<div class="mb-8 grid grid-cols-1 gap-4">
		<x-heading.main>Capolavori di {{ $student->full_name }}</x-heading.main>
		<x-subheading.main>Qui puoi scaricare i capolavori caricati durante il percorso.</x-subheading.main>
	</div>

	{{-- Masterpieces Table --}}
	@if ($student->masterpieces->isEmpty())
		<p class="mt-32 text-center text-neutral-500">Questo studente non ha ancora caricato nessun capolavoro.</p>
	@else
		<livewire:masterpieces.table :$student />
	@endif
</x-layouts.class-dashboard>
