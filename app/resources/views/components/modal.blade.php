@props(['id'])

@pushOnce('styles')
	<style>
		body:has(.modal[data-open='true']) {
			overflow: hidden;
		}
	</style>
@endpushOnce

@pushOnce('scripts')
	<script defer>
		function openModal(id) {
			const modal = document.getElementById(id);

			if (modal) {
				modal.setAttribute('data-open', 'true');
			}
		}

		function closeModal(event = null, id = null) {
			const modal = id ? document.getElementById(id) : event.target.closest('.modal');

			if (modal) {
				modal.setAttribute('data-open', 'false');
			}
		}

		document.addEventListener('keydown', function(event) {
			if (event.key === 'Escape') {
				const openModals = document.querySelectorAll('.modal[data-open="true"]');

				openModals.forEach(modal => {
					modal.setAttribute('data-open', 'false');
				});
			}
		});
	</script>
@endpushOnce

<div
	id="{{ $id }}"
	class="modal p-content-padding visibility-hidden pointer-events-none fixed inset-0 z-10 grid grid-cols-1 content-center justify-items-center opacity-0 transition-opacity data-[open='true']:pointer-events-auto data-[open='true']:visible data-[open='true']:opacity-100"
	data-open="false"
	x-data
>
	<span
		class="absolute inset-0 bg-gray-950/50"
		@click="closeModal($event, '{{ $id }}')"
	></span>

	{{ $slot }}
</div>
