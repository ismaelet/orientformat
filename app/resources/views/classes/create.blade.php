<x-layouts.form
	:$title
	size="lg"
>

	<x-slot name="body">

		<p>Vuoi aggiungere una nuova classe o vuoi collaborare alla gestione di una classe già creata da un/una collega?</p>

	</x-slot>

	<x-slot name="footer">
		<x-button
			href="{{ route('classes.create.middleschool') }}"
			class="center-icon"
		>
			<x-icon-add />
			Aggiungi una classe della scuola secondaria di primo grado
		</x-button>

		<x-button
			href="{{ route('classes.create.highschool') }}"
			class="center-icon"
			color="alternative"
		>
			<x-icon-add />
			Aggiungi una classe della scuola secondaria di secondo grado
		</x-button>

		<x-button
			href="{{ route('classes.join.show') }}"
			variant="secondary"
			class="center-icon"
		>
			<x-icon-group_add />
			Collabora a una classe già esistente
		</x-button>

	</x-slot>

</x-layouts.form>
