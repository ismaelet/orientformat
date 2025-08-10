<x-layouts.form
	:$title
	method="POST"
>
	<x-slot:body>

		<p class="py-4">Sei sicuro/a di voler uscire?</p>

	</x-slot:body>

	<x-slot:footer>

		<x-button type="submit">Logout</x-button>
		<x-button
			href="{{ route('home') }}"
			variant="secondary"
		>Indietro</x-button>

	</x-slot:footer>
</x-layouts.form>
