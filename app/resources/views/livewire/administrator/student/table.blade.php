@pushOnce('styles')
	<style>
		.fi-no {
			display: grid;
			justify-content: center;
			align-content: center;
		}

		.fi-no-notification-body {
			strong {
				color: var(--color-neutral-700);
			}
		}
	</style>
@endpushOnce

@pushOnce('scripts')
	<script defer>
		document.addEventListener('DOMContentLoaded', function() {
			document.addEventListener('click', function(event) {
				if (event.target.classList.contains('js-password')) {
					const password = event.target.textContent;
					navigator.clipboard.writeText(password).then(function() {
						event.target.setAttribute('data-copied', 'true');
						setTimeout(() => {
							event.target.removeAttribute('data-copied');
						}, 1000);
					}, function(err) {});
				}
			});
		});
	</script>
@endpushOnce

<div class="relative">
	{{ $this->table }}
</div>
