@pushOnce('styles')
	<style>
		.page-background {
			opacity: 0.3;
		}
	</style>
@endPushOnce

<x-layouts.empty>
	<div class="grid content-center justify-items-center gap-8">
		<x-heading.main>Errore 404</x-heading.main>
		<p>Pagina non trovata</p>
		<x-button
			href="{{ route('login') }}"
			variant="secondary"
			size="auto"
		>Torna alla
			home</x-button>
	</div>
</x-layouts.empty>
