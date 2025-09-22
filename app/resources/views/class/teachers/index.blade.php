<x-layouts.class-dashboard :$class>
	{{-- Page Header --}}
	<div class="mb-8 grid grid-cols-1 gap-4">
		<x-heading.main>Gestione docenti</x-heading.main>
		<x-subheading.main>Qui puoi visualizzare quali docenti sono associati a questa classe. I tutor di classe possono
			anche invitare o rimuovere docenti dalla gestione di classe, oppure trasferire la carica di
			tutor.
		</x-subheading.main>
	</div>

	{{-- Teacher Table --}}
	<livewire:teachers.table
		:$teacher
		:$class
	/>

	{{-- Teacher Invitation Button --}}
	<livewire:teachers.invitation-modal
		:$class
		:$teacher
	/>
</x-layouts.class-dashboard>
