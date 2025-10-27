@props(['title', 'test'])

@pushOnce('scripts')
	<script defer>
		document.addEventListener('DOMContentLoaded', () => {
			const timePassedField = document.querySelector('.js-time-passed');

			let secondsPassed = 0;

			setInterval(() => {
				secondsPassed++;
				timePassedField.value = secondsPassed;
			}, 1000);
		});
	</script>
@endpushOnce

<x-layouts.main :$title>
	<form
		method="POST"
		action="{{ route('test.store', $test) }}"
		class="full-width"
	>
		@csrf

		<input
			type="hidden"
			class="js-time-passed"
			name="speed"
			value="0"
		>

		{{ $slot }}
	</form>
</x-layouts.main>
