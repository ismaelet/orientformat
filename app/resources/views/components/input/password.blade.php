@pushOnce('scripts')
	<script defer>
		function togglePasswordVisibility(el) {
			const input = el.parentElement.querySelector('input');
			input.type = input.type === 'password' ? 'text' : 'password';
		}
	</script>
@endpushOnce

<div
	class="relative rounded"
	x-data="{ showPassword: false }"
	x-cloak
>
	<x-input {{ $attributes->merge(['type' => 'password']) }} />

	<div
		class="absolute bottom-0 right-0 top-0 grid w-10 cursor-pointer place-items-center rounded-r text-gray-500"
		@click="togglePasswordVisibility($el); showPassword = !showPassword"
	>
		<x-icon-visibility_lock
			class="h-5 w-5"
			x-bind:class="{ 'hidden': showPassword }"
		/>
		<x-icon-visibility_off
			class="h-5 w-5"
			x-bind:class="{ 'hidden': !showPassword }"
		/>
	</div>
</div>
